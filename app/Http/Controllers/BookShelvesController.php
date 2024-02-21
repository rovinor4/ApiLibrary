<?php

namespace App\Http\Controllers;

use App\Models\Bookshelves;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookShelvesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $data = new Bookshelves();

            if (isset($request->q) && !empty($request->q)) {
                $data = $data->where("name", "LIKE", "%$request->q%");
            }

            $data = $data->withCount("Book")->paginate(10);
            return ApiController::Success($data);
        } catch (\Exception $ex) {
            return ApiController::ErrorEx($ex);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                "name" => "required",
            ]);

            $dt = Bookshelves::create($data);
            return ApiController::Success($dt);
        } catch (ValidationException $ve) {
            return ApiController::ErrorInput($ve);
        } catch (\Exception $th) {
            return ApiController::ErrorEx($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookshelves $book_shelf)
    {
        try {
            $book_shelf->with("Book");
            return ApiController::Success($book_shelf);
        } catch (\Exception $th) {
            return ApiController::ErrorEx($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookshelves $book_shelf)
    {
        try {
            $data = $request->validate([
                "name" => "required",
            ]);

            $book_shelf->update($data);
            return ApiController::Success(null, message: "Success Update");
        } catch (ValidationException $ve) {
            return ApiController::ErrorInput($ve);
        } catch (\Exception $th) {
            return ApiController::ErrorEx($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookshelves $book_shelf)
    {
        //
    }
}
