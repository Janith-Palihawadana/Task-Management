<?php

namespace App\Http\Controllers;

use App\Mail\complete_task_mail;
use App\Models\Task;
use App\Services\ValidationFormatService;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TaskController extends Controller
{
    public function getTaskList(Request $request)
    {
        try {
            $list_count = $request->get('list_count');
            $task_list = Task::getTaskList($list_count);
            return $this->successReturn($task_list, 'Data Returned Successfully', ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorReturn([], 'Failed to return data', ResponseAlias::HTTP_BAD_REQUEST);
        }

    }

    public function createTask(Request $request)
    {

        $validator = ValidationService::createTaskValidator($request->all());
        if ($validator->fails()) {
            return $this->errorReturn([], ValidationFormatService::formatErrors($validator->errors()), ResponseAlias::HTTP_BAD_REQUEST);
        }
        try {
            Task::createTask($request->all());
            return $this->successReturn([], 'New Task added successfully', ResponseAlias::HTTP_CREATED);
        }
        catch (\Exception $e) {
            Log::error($e);
            return $this->errorReturn([], 'Failed to return data', ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    public function completeTask(Request $request)
    {
        try {
            $validator = ValidationService::completeTaskValidator($request->all());
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            Task::completeTask($request->all());
            $mail_details = Task::getTaskDetails($request->all());
            $this->sendMail($mail_details);

            return $this->successReturn([], 'Task completed successfully', ResponseAlias::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorReturn([], 'Failed to return data', ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    public function sendMail($mail_details)
    {
        $mailData = [
            'subject' => 'Complete Task Notification',
            'email' => 'test@gmail.com',
            'title' => $mail_details->title,
            'description' => $mail_details->description,
            'from' =>'admin@test.com'
        ];

        Mail::to('admin@test.com')->send(new complete_task_mail($mailData));
    }

}
