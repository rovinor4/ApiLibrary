<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        try {
            $data = $request->validate([
                "username" => "required",
                "password" => "required",
            ]);

            $username = $data["username"];
            $select = User::where("username", $username)->orWhere("email", $username)->orWhere("phone_number", $username)->first();

            if ($select) {
                $valid = [
                    "id" => $select->id,
                    "password" => $data["password"]
                ];

                if (Auth::attempt($valid)) {
                    $user = $request->user();
                    $now = Carbon::now();
                    $user["token"] = $user->createToken("Web Application - $now")->plainTextToken;
                    return ApiController::Success($user);
                }
            }

            return ApiController::Error("Username and password are incorrect, please try again.");
        } catch (ValidationException $vl) {
            return ApiController::ErrorInput($vl);
        } catch (\Exception $th) {
            return ApiController::ErrorEx($th);
        }
    }

    public function Register(Request $request)
    {
        try {
            $data = $request->validate([
                "name" => "required",
                "username" => "required|unique:users,username",
                "email" => "required|email|unique:users,email",
                "phone_number" => ["required", "unique:users,phone_number", "regex:/^(\+62|62|0)8\d{9,12}$/"],
                "password" => "required",
            ]);

            $data = User::create($data);

            return ApiController::Success($data);
        } catch (ValidationException $ve) {
            return ApiController::ErrorInput($ve);
        } catch (\Exception $th) {
            return ApiController::ErrorEx($th);
        }
    }


    public function Logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return ApiController::Success(null, "Success Logout");
        } catch (\Exception $th) {
            return ApiController::ErrorEx($th);
        }
    }


    public function LogoutAll(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            return ApiController::Success(null, "Success Logout All");
        } catch (\Exception $th) {
            return ApiController::ErrorEx($th);
        }
    }
}
