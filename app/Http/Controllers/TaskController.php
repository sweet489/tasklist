<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function GetAllTask() {
        $allTask = DB::table('tasks')->orderByRaw("created_at")->get();
        
        return $allTask; 
    }

    public function CreateOneTask(Request $request) {
        $bodyTask       = $request->input('body');
        $created_atTask = $request->input('created_at');
        DB::table("tasks")->insert(["body" => $bodyTask, "created_at" => $created_atTask]);
        $createdTasks = DB::table("tasks")->latest()->get();

        foreach ($createdTasks as $createdTask) {
            return [
                "status"        => "created",
                "id"            => $createdTask->id,
                "body"          => $createdTask->body, 
                "created_at"    => $createdTask->created_at, 
                "updated_at"    => $createdTask->updated_at
            ]; 
        }
    }

    public function UpdateOneTask(Request $request) {
        $idTask         = $request->input('id');  
        $bodyTask       = $request->input('body'); 
        $updated_atTask = $request->input('updated_at');
        DB::table("tasks")->where("id", $idTask)->update(["body" => $bodyTask, "updated_at" => $updated_atTask]);
        $updatedTasks = DB::table("tasks")->where("id", $idTask)->get();

        foreach ($updatedTasks as $updatedTask) {
            return [
                "status"        => "updated",
                "id"            => $updatedTask->id,
                "body"          => $updatedTask->body, 
                "created_at"    => $updatedTask->created_at, 
                "updated_at"    => $updatedTask->updated_at
            ]; 
        }
    }

    public function DeleteOneTask($idTask) {
        DB::table("tasks")->where("id", $idTask)->delete();

        if(DB::table("tasks")->where("id", $idTask)->doesntExist()) {
            return ["status" => "deleted"];
        } 
        else {
            return ["status" => "Error"];
        }
    }
}
