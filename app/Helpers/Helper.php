<?php

namespace App\Helpers;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Order;
use App\Models\Question;
use App\Models\QuestionDetail;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function getPageCategories()
    {
        $categories = Category::get();
        return $categories;
    }

    public static function getPageSubCategories($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();
        return $subcategories;
    }

    public static function getStuedntCourseData($id)
    {
        $course = array();
        $totalOrder = Order::where('student_id', $id)->where('order_type', 'Course')->count();
        $totalBilledAmount = Order::where('student_id', $id)
            ->where('order_type', 'Course')
            ->SUM('billed_amount');


        $lastOrder = Order::where('student_id', $id)->where('order_type', 'Course')->orderBy('id', 'DESC')->first();

        $course['totalOrder'] = $totalOrder;
        $course['totalBilledAmount'] = $totalBilledAmount;
        $course['lastOrderCode'] = $lastOrder->order_code ?? '';
        $course['lastOrderDate'] = $lastOrder->created_at ?? '';
        return $course;
    }

    public static function getStuedntTestSeriesData($id)
    {
        $testSeries = array();
        $totalOrder = Order::where('student_id', $id)->where('order_type', 'Test Series')->count();
        $totalBilledAmount = Order::where('student_id', $id)
            ->where('order_type', 'Test Series')
            ->SUM('billed_amount');

        $lastOrder = Order::where('student_id', $id)->where('order_type', 'Test Series')->orderBy('id', 'DESC')->first();

        $testSeries['totalOrder'] = $totalOrder;
        $testSeries['totalBilledAmount'] = $totalBilledAmount;
        $testSeries['lastOrderCode'] = $lastOrder->order_code ?? '';
        $testSeries['lastOrderDate'] = $lastOrder->created_at ?? '';
        return $testSeries;
    }

    public static function getStuedntStudyMaterialData($id)
    {
        $studyMaterial = array();
        $totalOrder = Order::where('student_id', $id)->where('order_type', 'Study Material')->count();
        $totalBilledAmount = Order::where('student_id', $id)
            ->where('order_type', 'Study Material')
            ->SUM('billed_amount');

        $lastOrder = Order::where('student_id', $id)->where('order_type', 'Study Material')->orderBy('id', 'DESC')->first();

        $studyMaterial['totalOrder'] = $totalOrder;
        $studyMaterial['totalBilledAmount'] = $totalBilledAmount;
        $studyMaterial['lastOrderCode'] = $lastOrder->order_code ?? '';
        $studyMaterial['lastOrderDate'] = $lastOrder->created_at ?? '';
        return $studyMaterial;
    }

    public static function getStuedntlastOrderID($id)
    {
        $lastOrder = Order::where('student_id', $id)->orderBy('id', 'DESC')->first();
        return $lastOrder->order_code ?? '-';
    }

    public static function GetStudentOrder($type, $id, $user_id)
    {
        $order = Order::where('student_id', $user_id)->where('order_type', $type)->where('package_id', $id)->first();
        if (!empty($order)) {
            return true;
        } else {
            return false;
        }
    }

    public static function limitTextChars($text, $limit = 100, $suffix = '...')
    {
        if (strlen($text) <= $limit)
            return $text;
        return substr($text, 0, $limit) . $suffix;
    }

    public static function getSubQuestionDetails($sub_question_id, $type, $negative_marks, $positive_marks)
    {
        $qDetails = [];
        $qDetails = QuestionDetail::where('id', $sub_question_id)->first();
        return $qDetails;
    }

    public static function getQuestionDetails($question_id, $type, $negative_marks, $positive_marks)
    {
        $qDetails = [];
        $qDetails = Question::where('id', $question_id)->first();

        return $qDetails;
    }

    public static function toRoman($number)
    {
        $map = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];

        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    /**
     * Check permission for sidebar & blade
     */
    public static function canAccess($permission)
    {
        $user = Auth::user();

        // Not logged in
        if (!$user) {
            return false;
        }
        // SUPER ADMIN (type = admin)
        if ($user->type === 'admin' && is_null($user->role_group_id)) {
            return true;
        }

        // Sub admin must have role group
        if (!$user->roleGroup) {
            return false;
        }

        $permissions = $user->roleGroup->permissions ?? [];

        return isset($permissions[$permission]) && $permissions[$permission] === 'yes';
    }

}
