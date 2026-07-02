<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\QuestionDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class QuestionsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    use Importable, SkipsFailures;

    private int $rows = 0;
    private int $successCount = 0;
    private int $pendingCount = 0;
    private int $rejectedCount = 0;
    private array $successdata = [];
    private array $pendingdata = [];
    private array $rejecteddata = [];

    // Declared explicitly to avoid PHP 8.2+ dynamic-property deprecation warnings
    protected $language;
    protected $question_category;
    protected $question_type;
    protected $fee_type;
    protected $commission_id;
    protected $previous_year;
    protected $category_id;
    protected $sub_category_id;
    protected $chapter_id;
    protected $subject_id;
    protected $topic;
    protected $passage_question_type;

    public function __construct(array $data)
    {
        $this->language              = $data['language'] ?? null;
        $this->question_category     = $data['question_category'] ?? null;
        $this->question_type         = $data['question_type'] ?? null;
        $this->fee_type              = $data['fee_type'] ?? null;
        $this->commission_id         = $data['commission_id'] ?? null;
        $this->previous_year         = $data['previous_year'] ?? null;
        $this->category_id           = $data['category_id'] ?? null;
        $this->sub_category_id       = $data['sub_category_id'] ?? null;
        $this->chapter_id            = $data['chapter_id'] ?? null;
        $this->subject_id            = $data['subject_id'] ?? null;
        $this->topic                 = $data['topic'] ?? null;
        $this->passage_question_type = $data['passage_question_type'] ?? null;
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        ++$this->rows;

        $question = isset($row['question']) ? trim((string) $row['question']) : '';
        if ($question === '') {
            // No question text on this row — nothing to import, skip silently.
            return null;
        }

        $instructionRaw   = isset($row['instruction']) ? trim((string) $row['instruction']) : '';
        $has_instruction  = $instructionRaw !== '';
        $instruction      = $has_instruction ? $instructionRaw : null;

        $solutionRaw      = isset($row['solution']) ? trim((string) $row['solution']) : '';
        $has_solution     = $solutionRaw !== '' ? 'yes' : 'no';
        $solution         = $has_solution === 'yes' ? $solutionRaw : null;

        $optionERaw       = isset($row['option_e']) ? trim((string) $row['option_e']) : '';
        $has_option_e     = $optionERaw !== '';

        // Excel header is literally "PYQ", which Laravel Excel slugs to the key "pyq"
        $pyqRaw           = isset($row['pyq']) ? strtolower(trim((string) $row['pyq'])) : '';
        $show_on_pyq      = $pyqRaw === 'yes' ? 'yes' : 'no';

        $questions = [
            'language'             => $this->language,
            'question_category'    => $this->question_category,
            'question_type'        => $this->question_type,
            'fee_type'             => $this->fee_type,
            'commission_id'        => $this->commission_id,
            'previous_year'        => $this->previous_year,
            'category_id'          => $this->category_id,
            'sub_category_id'      => $this->sub_category_id,
            'chapter_id'           => $this->chapter_id,
            'subject_id'           => $this->subject_id,
            'topic'                => $this->topic,
            'passage_question_type'=> $this->passage_question_type,
            'question'             => $question,
            'solution'             => $solution,
            'has_solution'         => $has_solution,
            'has_option_e'         => $has_option_e,
            'instruction'          => $instruction,
            'has_instruction'      => $has_instruction,
            'show_on_pyq'          => $show_on_pyq,
            'added_by_id'          => auth()->id(),
            'added_by_type'        => 'user',
        ];

        $rejectReason = null;

        if ($this->question_type == 'MCQ') {
            $answerRaw = isset($row['answer']) ? trim((string) $row['answer']) : '';

            $questions['option_a'] = $row['option_a'] ?? null;
            $questions['option_b'] = $row['option_b'] ?? null;
            $questions['option_c'] = $row['option_c'] ?? null;
            $questions['option_d'] = $row['option_d'] ?? null;
            $questions['option_e'] = $has_option_e ? $row['option_e'] : null;
            $questions['answer']   = $answerRaw !== '' ? strtoupper($answerRaw) : null;

            if ($answerRaw === '') {
                $rejectReason = 'Answer missing';
            }
        } elseif ($this->question_type == 'Subjective') {
            $answerFormatRaw = isset($row['answer_format']) ? trim((string) $row['answer_format']) : '';
            $questions['answer_format'] = $answerFormatRaw !== '' ? $answerFormatRaw : 'text input';
        } elseif ($this->question_type == 'Story Based') {
            $answerFormatRaw = isset($row['answer_format']) ? trim((string) $row['answer_format']) : '';
            $questions['answer_format'] = $answerFormatRaw !== '' ? $answerFormatRaw : null;
        }

        // Duplicate check — mirrors the docx importer's logic against the Question table
        $duplicate = Question::where('question', $question)
            ->where('commission_id', $this->commission_id)
            ->where('category_id', $this->category_id)
            ->where('sub_category_id', $this->sub_category_id)
            ->where('subject_id', $this->subject_id)
            ->when($this->previous_year, function ($q) {
                $q->where('previous_year', $this->previous_year);
            })
            ->first();

        if ($duplicate) {
            $rejectReason = 'Already Exists Question.';
        }

        if ($rejectReason) {
            $questions['status'] = 'Rejected';
            $questions['note']   = $rejectReason;
        } else {
            $questions['status'] = 'Done';
            $questions['note']   = null;
        }

        // Story Based rows carry a passage sub-question in the same Excel row.
        // Because ToModel + WithBatchInserts defers the actual INSERT, we cannot
        // rely on $saveques->id here — it will still be null when the batch runs.
        // So for Story Based we save the Question immediately (outside the batch)
        // to get a real ID, then attach the QuestionDetail, and return null so
        // Laravel Excel doesn't try to insert it again via the batch.
        if ($this->question_type == 'Story Based') {
            $saveques = Question::create($questions);

            $passageQuestion = isset($row['passage_question']) ? trim((string) $row['passage_question']) : '';

            if ($passageQuestion !== '') {
                $detailOptionERaw = isset($row['option_e']) ? trim((string) $row['option_e']) : '';
                $detailHasOptionE = $detailOptionERaw !== '';

                $isMcqSub = isset($row['answer']) && trim((string) $row['answer']) !== '';

                $questionDetails = [
                    'question_id'  => $saveques->id,
                    'question'     => $passageQuestion,
                    'has_option_e' => $detailHasOptionE,
                    'type'         => $isMcqSub ? 'mcq' : 'reasoning',
                ];

                if ($isMcqSub) {
                    $questionDetails['option_a'] = $row['option_a'] ?? null;
                    $questionDetails['option_b'] = $row['option_b'] ?? null;
                    $questionDetails['option_c'] = $row['option_c'] ?? null;
                    $questionDetails['option_d'] = $row['option_d'] ?? null;
                    $questionDetails['option_e'] = $detailHasOptionE ? $row['option_e'] : null;
                    $questionDetails['answer']   = strtoupper(trim((string) $row['answer']));
                } else {
                    $questionDetails['answer_format'] = isset($row['answer_format'])
                        ? trim((string) $row['answer_format'])
                        : null;
                }

                if ($solution) {
                    $questionDetails['solution'] = $solution;
                }

                QuestionDetail::create($questionDetails);
            }

            if ($rejectReason) {
                $this->rejectedCount++;
                $this->rejecteddata[] = $questions;
            } else {
                $this->successCount++;
                $this->successdata[] = $questions;
            }

            // Already persisted manually — returning null skips the batch insert for this row.
            return null;
        }

        // MCQ / Subjective: let Laravel Excel handle the batched insert as normal.
        if ($rejectReason) {
            $this->rejectedCount++;
            $this->rejecteddata[] = $questions;
        } else {
            $this->successCount++;
            $this->successdata[] = $questions;
        }

        return new Question($questions);
    }

    public function batchSize(): int
    {
        return 200;
    }

    public function chunkSize(): int
    {
        return 200;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getPendingCount()
    {
        return $this->pendingCount;
    }

    public function getRejectedCount()
    {
        return $this->rejectedCount;
    }

    public function getSuccessData()
    {
        return $this->successdata;
    }

    public function getPendingData()
    {
        return $this->pendingdata;
    }

    public function getRejectedData()
    {
        return $this->rejecteddata;
    }

    public function rules(): array
    {
        return [
            // 'question' => 'required',
        ];
    }
}