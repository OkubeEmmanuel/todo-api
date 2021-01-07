<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\Todo as TodoResource;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TodoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all();
    
        return $this->sendResponse(TodoResource::collection($todos), 'Todos retrieved successfully.');
    }
    
    /**
     * Store a newly created resource in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'task' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $todo = Todo::create($input);
   
        return $this->sendResponse(new TodoResource($todo), 'Todo created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  App\Models\Todo  $todo
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {  
        if (is_null($todo)) {
            return $this->sendError('Todo not found.');
        }
   
        return $this->sendResponse(new TodoResource($todo), 'Todo retrieved successfully.');
    }
    
    /**
     * Update the specified resource in database.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  App\Models\Todo          $todo
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'task' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $todo->task = $input['task'];
        $todo->save();
   
        return $this->sendResponse(new TodoResource($todo), 'Todo updated successfully.');
    }

     /**
     * Update the specified resource as completed.
     *
     * @param  App\Models\Todo  $todo
     * 
     * @return \Illuminate\Http\Response
     */
    public function taskCompleted(Todo $todo)
    {   
        $todo->completed = 1;
        $todo->save();
   
        return $this->sendResponse(new TodoResource($todo), 'Todo updated successfully.');
    }

    /**
     * Update the specified resource as not completed.
     *
     * @param  App\Models\Todo  $todo
     * 
     * @return \Illuminate\Http\Response
     */
    public function taskNotCompleted(Todo $todo)
    {   
        $todo->completed = 0;
        $todo->save();
   
        return $this->sendResponse(new TodoResource($todo), 'Todo updated successfully.');
    }
   
    /**
     * Remove the specified resource from database.
     *
     * @param  App\Models\Todo  $todo
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
   
        return $this->sendResponse([], 'Todo deleted successfully.');
    }
}
