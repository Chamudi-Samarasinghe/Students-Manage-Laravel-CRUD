<?php

namespace App\Http\Controllers;

use domain\Facades\StudentFacades;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    protected $task;

    
    public function index()
    {
        return Inertia::render('Student/index');
    }

    
    public function store(Request $request)
    {
        return StudentFacades::store($request->all());
    }

    
    public function list()
    {
        $students = StudentFacades::all();
        return response()->json($students);
    }

    
    public function get($student_id)
    {
        $student =  StudentFacades::get($student_id);
        return response()->json($student);
    }

    
    public function status($status_id)
    {
        return StudentFacades::status($status_id);
    }

    
    public function edit(Request $request)
    {
        $student =  StudentFacades::get($request);
        return response()->json($student);
    }

    
    public function update(Request $request, $student_id)
    {
        return StudentFacades::update($request->all(), $student_id);
    }

    public function delete($student_id)
    {
        return  StudentFacades::delete($student_id);
    }

}
