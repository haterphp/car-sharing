<?php

namespace App\Http\Controllers;

use App\Http\Resources\BranchCarsResource;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('cars')
            ->get()
            ->map(fn($car) => [
                'id' => $car->id,
                'name' => $car->name,
                'cars' => BranchCarsResource::collection($car->cars)
            ]);
        return response()->json([
            'data' => [
                'items' => $branches
            ]
        ], 200);
    }
}
