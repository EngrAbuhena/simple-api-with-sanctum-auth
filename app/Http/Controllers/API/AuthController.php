<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
//    }
    /**
     * Register Api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        // use validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'User Registration Failed'
            ], 404);
        }

        $input = $request->all();
        $input['email'] = strtolower($request->email);
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);

        $success = [
            'success' => true,
            'message' => 'User created successfully',
            'token' => $user->createToken('MyToken')->plainTextToken,
            'name' => $user->name
        ];

        return response()->json($success, 201);
    }

    /**
     * Login Api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator=Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'status'=>401
            ], 401);
        }

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'status'=>401
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $user->createToken('ApiToken')->plainTextToken,
                'type' => 'bearer',
            ]
        ],200);
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function userDetails(): JsonResponse
    {
        if (Auth::check()) {

            $user = Auth::user();

            return response()->json([
                'success'=>true,
                'data' => $user,
                'status=>200'
            ],200);
        }

        return response()->json([
            'success'=>false,
            'data' => 'Unauthorized',
            'status'=>401
        ],401);
    }

    /**
     * Logout Api
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out',
        ], 200);
    }

    //    public function refresh(): JsonResponse
    //    {
    //        return response()->json([
    //            'user' => Auth::user(),
    //            'authorisation' => [
    //                'token' => Auth::refresh(),
    //                'type' => 'bearer',
    //            ]
    //        ]);
    //    }
}
