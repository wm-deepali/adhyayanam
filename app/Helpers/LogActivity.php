<?php


namespace App\Helpers;
use Request;
use App\Models\LogActivity as LogActivityModel;


class LogActivity
{


    public static function addToLog($subject,$user)
    {
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = $user->id ?? 0;
        $log['user_name'] = $user->name ?? '';
		$log['updated_by'] = auth()->check() ? auth()->user()->name : '';
		$log['updated_by_id'] = auth()->check() ? auth()->user()->id : '';
		if($user->is_save_activity == 'Yes')
		{
		    LogActivityModel::create($log);
		}
    	
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }
    
    public static function userLogActivityLists()
    {
    	return LogActivityModel::where('user_id', auth()->user()->id)->latest()->get();
    }


}