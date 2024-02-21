<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    public static function Success($query, $message = null)
    {
        return response()->json([
            "query" => $query ?? null,
            "message" => $message ?? "Success"
        ]);
    }


    public static function ErrorInput(ValidationException $ve)
    {
        return response()->json([
            "errors" => $ve->errors(),
            "message" => $ve->getMessage()
        ]);
    }

    public static function ErrorEx(\Exception $ex)
    {
        return response()->json([
            "message" => env("APP_DEBUG") ? $ex->getMessage() : "An error occurred, please try again."
        ]);
    }

    public static function Error($message)
    {
        return response()->json([
            "message" => $message
        ]);
    }
}
