<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CurrentAffair;
use App\Models\StudyMaterial;
use App\Models\Syllabus;
use App\Models\Test;
use App\Models\TestSeries;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $query = trim($request->get('q', ''));

        if ($query === '' || strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'results' => []
            ]);
        }

        $results = collect();

        /* ================= TEST SERIES ================= */

        $testSeries = TestSeries::with(['commission', 'category', 'subcategory'])
            ->where(function ($q) use ($query) {

                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('short_description', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('overview', 'LIKE', "%{$query}%")
                    ->orWhere('language', 'LIKE', "%{$query}%")
                    ->orWhere('validity', 'LIKE', "%{$query}%")
                    ->orWhere('test_generated_by', 'LIKE', "%{$query}%")

                    ->orWhereHas('commission', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('category', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('subcategory', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->limit(5)
            ->get();

        foreach ($testSeries as $item) {
            $results->push([
                'name' => $item->title,
                'type' => 'Test Series',
                'breadcrumb' => collect([
                    $item->commission->name ?? null,
                    $item->category->name ?? null,
                    $item->subcategory->name ?? null,
                ])->filter()->implode(' / '),
                'url' => ($item->commission && $item->category && $item->subcategory)
                    ? route('test-series-list', [
                        'examSlug' => $item->commission->slug,
                        'catSlug' => $item->category->slug,
                        'subCatSlug' => $item->subcategory->slug,
                    ])
                    : '#',
            ]);
        }

        /* ================= COURSES ================= */

        $courses = Course::with([
            'examinationCommission',
            'category',
            'subCategory'
        ])
            ->where(function ($q) use ($query) {

                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('short_description', 'LIKE', "%{$query}%")
                    ->orWhere('course_heading', 'LIKE', "%{$query}%")
                    ->orWhere('course_overview', 'LIKE', "%{$query}%")
                    ->orWhere('detail_content', 'LIKE', "%{$query}%")
                    ->orWhere('language_of_teaching', 'LIKE', "%{$query}%")

                    ->orWhereHas('examinationCommission', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('category', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('subCategory', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->limit(5)
            ->get();

        foreach ($courses as $item) {
            $results->push([
                'name' => $item->name,
                'type' => 'Course',
                'breadcrumb' => collect([
                    $item->examinationCommission->name ?? null,
                    $item->category->name ?? null,
                    $item->subCategory->name ?? null,
                ])->filter()->implode(' / '),
                'url' => ($item->examinationCommission && $item->category && $item->subCategory)
                    ? route('courses', [
                        'examSlug' => $item->examinationCommission->slug,
                        'catSlug' => $item->category->slug,
                        'subCatSlug' => $item->subCategory->slug,
                    ])
                    : '#',
            ]);
        }

        /* ================= STUDY MATERIAL ================= */

        $materials = StudyMaterial::with([
            'commission',
            'category',
            'subcategory'
        ])
            ->where(function ($q) use ($query) {

                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('short_description', 'LIKE', "%{$query}%")
                    ->orWhere('detail_content', 'LIKE', "%{$query}%")
                    ->orWhere('language', 'LIKE', "%{$query}%")

                    ->orWhereHas('commission', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('category', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('subcategory', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->limit(5)
            ->get();

        foreach ($materials as $item) {
            $results->push([
                'name' => $item->title,
                'type' => 'Study Material',
                'breadcrumb' => collect([
                    $item->commission->name ?? null,
                    $item->category->name ?? null,
                    $item->subcategory->name ?? null,
                ])->filter()->implode(' / '),
                'url' => ($item->commission && $item->category && $item->subcategory)
                    ? route('study.material.front', [
                        'examSlug' => $item->commission->slug,
                        'catSlug' => $item->category->slug,
                        'subCatSlug' => $item->subcategory->slug,
                    ])
                    : '#',
            ]);
        }


        $currentAffairs = CurrentAffair::with('topic')
            ->where(function ($q) use ($query) {

                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('short_description', 'LIKE', "%{$query}%")
                    ->orWhere('details', 'LIKE', "%{$query}%")

                    ->orWhereHas('topic', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    });

            })
            ->limit(5)
            ->get();

        foreach ($currentAffairs as $item) {
            $results->push([
                'name' => $item->title,
                'type' => 'Current Affair',
                'breadcrumb' => $item->topic->name ?? '',
                'url' => route('current.details', $item->id) // adjust route
            ]);
        }


        $tests = Test::where('paper_type', 1)
            ->with([
                'commission',
                'category',
                'subcategory',
                'subject',
                'chapter',
                'topic'
            ])
            ->where(function ($q) use ($query) {

                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('test_code', 'LIKE', "%{$query}%")
                    ->orWhere('language', 'LIKE', "%{$query}%")
                    ->orWhere('paper_type', 'LIKE', "%{$query}%")
                    ->orWhere('test_type', 'LIKE', "%{$query}%")
                    ->orWhere('test_instruction', 'LIKE', "%{$query}%")

                    ->orWhereHas('commission', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('category', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('subcategory', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('subject', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('chapter', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('topic', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    });

            })
            ->limit(5)
            ->get();

        foreach ($tests as $item) {
            $results->push([
                'name' => $item->name,
                'type' => 'PYQ Test',
                'breadcrumb' => collect([
                    $item->commission->name ?? null,
                    $item->category->name ?? null,
                    $item->subcategory->name ?? null,
                    $item->subject->name ?? null,
                ])->filter()->implode(' / '),

                'url' => route('pyq-papers', [
                    'examSlug' => $item->commission->slug,
                    'catSlug' => $item->category->slug,
                    'subCatSlug' => $item->subcategory->slug,
                ])
            ]);
        }

        $syllabus = Syllabus::with([
            'commission',
            'category',
            'subCategory',
            'subject'
        ])
            ->where(function ($q) use ($query) {

                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('detail_content', 'LIKE', "%{$query}%")
                    ->orWhere('type', 'LIKE', "%{$query}%")

                    ->orWhereHas('commission', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('category', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('subCategory', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })

                    ->orWhereHas('subject', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    });

            })
            ->limit(5)
            ->get();

        foreach ($syllabus as $item) {
            $results->push([
                'name' => $item->title,
                'type' => 'Syllabus',
                'breadcrumb' => collect([
                    $item->commission->name ?? null,
                    $item->category->name ?? null,
                    $item->subCategory->name ?? null,
                    $item->subject->name ?? null,
                ])->filter()->implode(' / '),
                'url' => route('syllabus.front', [
                    'examSlug' => $item->commission->slug,
                    'catSlug' => $item->category->slug,
                    'subCatSlug' => $item->subCategory->slug,
                ])
            ]);
        }

        return response()->json([
            'success' => true,
            'results' => $results->take(15)->values(),
        ]);
    }

}