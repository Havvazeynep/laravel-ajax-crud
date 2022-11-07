<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index() {
        return view('student.index');
    }

    public function fetchStudent() {
        $students = Student::all();
        return response()->json([
            'students' => $students,
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|max:100',
            'course' => 'required|max:100',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->getMessageBag(),
            ]);
        } else {
            $student = new Student;
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->course = $request->input('course');
            $student->save();
            return response()->json([
                'status' => 200,
                'message' => 'Student Added Successfully',
            ]);
        }
    }

    public function edit($id) {
        $student = Student::find($id);
        if($student) {
            return response()->json([
                'status' => 200,
                'student' => $student,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student Not Found',
            ]);
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|max:100',
            'course' => 'required|max:100',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->getMessageBag(),
            ]);
        } else {
            $student = Student::find($id);
            if($student) {
                $student->name = $request->input('name');
                $student->email = $request->input('email');
                $student->phone = $request->input('phone');
                $student->course = $request->input('course');
                $student->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Student Update Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student Not Found',
                ]);
            }
            
        }
    }

    public function destroy($id) {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Student Deleted Successfully',
        ]);
    }
}
