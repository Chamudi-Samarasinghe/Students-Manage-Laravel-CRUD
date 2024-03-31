<?php

namespace domain\Services;

use App\Models\Student;



class StudentService
{
    protected $student;

   
    public function __construct()
    {
        $this->student = new Student();
    }

    
    public function all()
    {
        return  $this->student->all();
    }

    
    public function get($student_id)
    {
        return  $this->student->find($student_id);
    }

    
    public function store($data)
    {
        $this->student->create($data);
    }

    
    public function edit(Student $student, $data)
    {
        return  array_merge($student->toArray(), $data);
    }

    
    public function update(array $data, $student_id)
    {
        $student =  $this->student->find($student_id);
        $student->update($this->edit($student, $data));
    }

    
    public function status($student_id)
    {
        $student = $this->student->find($student_id);
        if ($student->status == 1) {
            $student->status = 0;
        } else {
            $student->status = 1;
        }
        $student->update();
    }

    public function delete($student_id)
    {
        $student =  $this->student->find($student_id);
        $student->delete();
    }
}
