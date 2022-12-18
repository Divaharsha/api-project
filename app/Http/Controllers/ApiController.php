<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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


        // Check if a user with the given email address exists in the database
            $userExists = DB::table('students')->where('mobile', $request->input('mobile'))->exists();
            if ($userExists) {
                return response()->json([
                   "success" => false ,
                    'message' => 'Mobile Number Already exists'
                ], 400);
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
  
      public function updateStudent(Request $request) {
       
        $user_id = $request->input('user_id');
        $name = $request->input('name');
        $password = $request->input('password');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $occupation = $request->input('occupation');
        $gender = $request->input('gender');
        $address = $request->input('address');
        $district = $request->input('district');
        $pincode = $request->input('pincode');

        if(empty($user_id)){
            return response()->json([
                'success'=>false,
                'message' => 'User Id is Empty',
            ], 200);
        }
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

        $student =Student::where('id',$user_id)->get();
        if(count($student)==1){
            $student = Student::find($user_id);
            $student->name = $request->name;
            $student->email = $request->email;
            $student->mobile = $request->mobile;
            if ($request->has('password')) {
              $student->password = Hash::make($request->input('password'));
             }
            $student->occupation = $request->occupation;
            $student->gender = $request->gender;
            $student->address = $request->address;
            $student->district = $request->district;
            $student->pincode = $request->pincode;
            $student->save();
            return response()->json([
              'success'=>true,
              'message' => 'Student Details Updated Successfully',
              'data' =>$student,
          ], 200);
        }
        else{
              return response()->json([
                'success'=>false,
                'message' => 'Student Not Found',
            ], 404);

        }
        
      }
  
      public function deleteStudent ($id) {
        // logic to delete a student record goes here
      }
}
