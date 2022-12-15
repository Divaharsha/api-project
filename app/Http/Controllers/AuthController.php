<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $mobile = $request->input('mobile');
        $password = $request->input('password');

        if(empty($mobile)){
            return response()->json([
                'success'=>false,
                'message' => 'Mobile Number is Empty',
            ], 200);

        }
        if(empty($password)){
            return response()->json([
                'success'=>false,
                'message' => 'Password is Empty',
            ], 200);

        }

        $student = Student::where('mobile', $mobile)->first();

        if ($student && $student->password == $password) {
            return response()->json([
                'success'=>true,
                'message' => 'Logged In successfully',
                'data' => [$student]
            ], 200);
        }

        return response()->json([
            'success'=>false,
            'message' => 'User Not Found Or Invalid Credentials',
        ], 401);
    }
}

