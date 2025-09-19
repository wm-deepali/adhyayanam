<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\QuestionBank;
use App\Models\QuestionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;


 //This line needs to add manually


//SkipsOnFailure,
class QuestionsImport implements ToModel, WithHeadingRow, WithBatchInserts,WithChunkReading,WithValidation
{
    private $rows = 0;
    protected $data;
    private $successCount = 0;
    private $pendingCount = 0;
    private $rejectedCount = 0;
    private $successdata = [];
    private $pendingdata = [];
    private $rejecteddata = [];
    function __construct($data) {
      
             
        $this->language = $data['language'];
        $this->question_category =$data['question_category'];
        $this->question_type =$data['question_type'];
        $this->fee_type =$data['fee_type'];
        $this->commission_id = $data['commission_id'];
        $this->previous_year = $data['previous_year'];
        $this->category_id = $data['category_id'];
        $this->sub_category_id = $data['sub_category_id'];
        $this->subject_id = $data['subject_id'];
        $this->topic = $data['topic'];
        
    }

    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        ++$this->rows;
        if(!empty($row['question']))
        {
          
        $que = utf8_decode($row['question']);
        $has_instruction = $row['instruction'] !='' ? true : false;
        $instruction = utf8_decode($row['instruction']) ?? Null;
        $has_option_e = isset($row['option_e']) && $row['option_e'] !='' ? true : false;
        $has_solution = isset($row['solution']) && $row['solution'] !='' ? "yes" : "no";

        // $questionBank = new QuestionBank();
        // $questionBank->language = $this->language;
        // $questionBank->question_category = $this->question_category;
        // $questionBank->commission_id = $this->commission_id;
        // $questionBank->previous_year = $this->previous_year;
        // $questionBank->category_id = $this->category_id;
        // $questionBank->subject_id = $this->subject_id;
        // $questionBank->topic = $this->topic;
        // $questionBank->question = $que;
        // $questionBank->has_instruction = $has_instruction;
        // $questionBank->instruction = $instruction;
        // $questionBank->has_option_e = $has_option_e;
        
        

        $questions=([
            'question' => $row['question'],
        ]);
        $questions['language'] = $this->language;
        $questions['question_category'] = $this->question_category;
        $questions['question_type'] = $this->question_type;
        $questions['fee_type'] = $this->fee_type;
        $questions['commission_id'] = $this->commission_id;
        $questions['previous_year'] = $this->previous_year;
        $questions['category_id'] = $this->category_id;
        $questions['sub_category_id'] = $this->sub_category_id;
        $questions['subject_id'] = $this->subject_id;
        $questions['topic'] = $this->topic;
        $questions['passage_question_type'] = $this->passage_question_type;
        $questions['solution'] = $row['solution'] ?? NUll;
        $questions['has_option_e'] = $has_option_e;
        $questions['instruction'] = $instruction;
        if($this->question_type == 'MCQ')
        {
            $questions['option_a'] = $row['option_a'] ?? Null;
            $questions['option_b'] = $row['option_b'] ?? Null;
            $questions['option_c'] = $row['option_c'] ?? Null;
            $questions['option_d'] = $row['option_d'] ?? Null;
            $questions['option_e'] = $row['option_e'] ?? Null;
            $questions['answer'] = strtoupper($row['answer']) ?? Null;
        }
        elseif($this->question_type == 'Subjective')
        {
            $questions['answer_format'] = $row['answer_format'] ?? NULL;
        }
        elseif($this->question_type == 'Story Based')
        {
            $questions['answer_format'] = $row['answer_format'] ?? NULL;
            $questionDetails['question'] = $row['passage_question'] ?? NULL;
            $questionDetails['option_a'] = $row['option_a'] ?? Null;
            $questionDetails['option_b'] = $row['option_b'] ?? Null;
            $questionDetails['option_c'] = $row['option_c'] ?? Null;
            $questionDetails['option_d'] = $row['option_d'] ?? Null;
            $questionDetails['option_e'] = $row['option_e'] ?? Null;
            $has_option_e = isset($row['option_e']) && $row['option_e'] !='' ? true : false;
            $questionDetails['has_option_e'] = $has_option_e;
            $questionDetails['answer_format'] = $row['answer_format'] ?? NULL;
        }
        
        
        if ($this->isValid($row)) {
            // $questionBank->save();
            // $questions['question_bank_id'] = $questionBank->id;
            $this->successCount++;
            $this->successdata[] = $questions;
            $saveques = new Question($questions);
            if($saveques)
            {
                $questionDetails['question_id'] = $saveques->id;
                if(isset($questionDetails) && !empty($questionDetails))
                {
                    QuestionDetail::create($questionDetails);
                }
            }
            return $saveques;
        } else {
            // $questionBank->save();
            $this->rejectedCount++;
            // $questions['question_bank_id'] = $questionBank->id;
            $questions['status'] = "Rejected";
            $questions['note'] = "Already Exists Question.";
            $saveques = new Question($questions);
            if($saveques)
            {
                $questionDetails['question_id'] = $saveques->id;
                if(isset($questionDetails) && !empty($questionDetails))
                {
                    QuestionDetail::create($questionDetails);
                }
            }
            return $saveques;
        }
        // return new Question($questions);
    }
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
    private function isValid($row)
    {
        $que =   QuestionBank::where('question',$row['question'])
        // ->where('question_category',$this->question_category)
        // ->where('commission_id',$this->commission_id)
        // ->where('category_id',$this->category_id)
        ->where('subject_id',$this->subject_id)
        ->where('topic',$this->topic)->first();
        if($que){
            return false;
        }else{
            return true;
        }
    }
    
    public function rules(): array
    {
        //dd($this->rows);
        return [
           // 'question' => 'required',
        ];
    }
}
