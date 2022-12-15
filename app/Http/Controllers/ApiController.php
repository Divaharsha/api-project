<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
      public function getAllStudents() {

            $students = Student::all();
            return response()->json([
                'success' => true,
                'message' => 'Students Retrieved Successfully',
                'data' => $students
            ],201);
        }
  
      public function createStudent(Request $request) {
     
        $name = $request->input('name');
        $password = $request->input('password');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $occupation = $request->input('occupation');
        $gender = $request->input('gender');
        $address = $request->input('address');
        $district = $request->input('district');
        $pincode = $request->input('pincode');

        if(empty($name)){
            return response()->json([
                'success'=>false,
                'message' => 'Name is Empty',
            ], 200);
        }
        if(empty($password)){
            return response()->json([
                'success'=>false,
                'message' => 'Password is Empty',
            ], 200);
        }
        if(empty($email)){
          return response()->json([
              'success'=>false,
              'message' => 'Email is Empty',
          ], 200);
        }
        if(empty($mobile)){
            return response()->json([
                'success'=>false,
                'message' => 'Mobile Number is Empty',
            ], 200);
        }
        if(empty($occupation)){
          return response()->json([
              'success'=>false,
              'message' => 'Occupation is Empty',
          ], 200);
        }
        if(empty($gender)){
            return response()->json([
                'success'=>false,
                'message' => 'Gender is Empty',
            ], 200);
        }
        if(empty($address)){
              return response()->json([
            'success'=>false,
            'message' => 'Address is Empty',
        ], 200);
        }
        if(empty($district)){
            return response()->json([
                'success'=>false,
                'message' => 'District is Empty',
            ], 200);
        }
        if(empty($pincode)){
          return response()->json([
              'success'=>false,
              'message' => 'Pincode is Empty',
          ], 200);
        }

            $student = new Student;
            $student->name = $request->name;
            $student->email = $request->email;
            $student->mobile = $request->mobile;
            $student->password = $request->password;
            $student->occupation = $request->occupation;
            $student->gender = $request->gender;
            $student->address = $request->address;
            $student->district = $request->district;
            $student->pincode = $request->pincode;
            $student->save();
        
            return response()->json([
              "success" => true ,
              'message'=> "Registered Successfully",
              'data' =>[$student]
            ], 201);
      }
  
      public function getStudent($id) {
        // logic to get a student record goes here
      }
  
      public function updateStudent(Request $request, $id) {
        // logic to update a student record goes here
      }
  
      public function deleteStudent ($id) {
        // logic to delete a student record goes here
      }
}
