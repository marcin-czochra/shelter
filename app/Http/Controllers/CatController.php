<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatRequest;
use App\Models\Cat;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CatController extends Controller
{
    private function saveCat(array $data): Cat
    {
        $cat = new Cat();
        $cat->name = $data['name'];
        $cat->branch_id = $data['branch_id'];
        $cat->save();

        return $cat;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Cat::with('branch');

        // Filtering
        if ($request->has('branch_ids')) {
            $branchIds = $request->input('branch_ids');
            $query->whereIn('branch_id', $branchIds);
        }

        // Sorting
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $cats = $query->paginate(10);
        return response()->json($cats);
    }

    public function store(CatRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $cat = $this->saveCat($validatedData);

            return response()->json($cat, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
    }


    public function show(Cat $cat): JsonResponse
    {
        try {
            $cat = Cat::with('branch')->where('id', $cat->id)->firstOrFail();
            return response()->json($cat);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cat not found'], 404);
        }
    }


    public function update(CatRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $cat = $this->saveCat($validatedData);

            return response()->json($cat);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
    }

    public function destroy(Cat $cat): JsonResponse
    {
        try {
            $cat = Cat::with('branch')->where('id', $cat->id)->firstOrFail();
            $cat->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cat not found'], 404);
        }
    }
}
