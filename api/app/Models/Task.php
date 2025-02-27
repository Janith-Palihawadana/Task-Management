<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'is_completed' => 'bool'
    ];

    public static function getTaskList($count)
    {
        $query = Task::query()
            ->select('tasks.title','tasks.id','tasks.description', 'tasks.is_completed', 'tasks.is_active', 'tasks.created_at')
            ->where('tasks.is_active', 1)
            ->orderBy('tasks.created_at', 'desc')
            ->limit($count)
            ->get();

        return $query;
    }

    public static function createTask($all)
    {
        Task::create([
            'title' => $all['title'],
            'description' => $all['description'],
            'is_completed' => $all['is_completed'],
            'is_active' => $all['is_active'],
        ]);
    }

    public static function completeTask($request)
    {
        Task::where('id',$request['task_id'])
            ->update([
                'is_completed' => 1,
                'updated_at' => now()
            ]);
    }

    public static function getTaskDetails($request)
    {
        return Task::where('id',$request['task_id'])
            ->select('title','description')
            ->first();
    }
}
