<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function search(Request $request)
    {
        $result = Car::with('branch')
            ->ofMark($request->mark ?? '')
            ->ofModel($request->model ?? '');

        return response()->json([
            'data' => [
                'items' => $result->get()
            ]
        ], 200);
    }
}
