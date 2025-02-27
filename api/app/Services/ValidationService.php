<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidationService
{

    public static function createTaskValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'is_completed' => 'required|boolean',
            'is_active' => 'required|boolean',
        ]);
    }

    public static function completeTaskValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request, [
            'task_id' => 'required|integer',
        ]);

    }
}
