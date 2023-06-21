<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BranchController extends Controller
{
    private function saveBranch(array $data): Branch
    {
        $branch = new Branch();
        $branch->name = $data['name'];
        $branch->location = $data['location'];
        $branch->save();

        return $branch;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Branch::query();

        // Filtering by location - array
        if ($request->has('location')) {
            $locations = $request->input('location');
            $query->whereIn('location', $locations);
        }

        // Sorting
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $branches = $query->paginate(10);
        return response()->json($branches);
    }

    public function store(BranchRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $branch = $this->saveBranch($validatedData);

            return response()->json($branch, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
    }


    public function show(Branch $branch): JsonResponse
    {
        try {
            $branch = Branch::where('id', $branch->id)->firstOrFail();
            return response()->json($branch);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Branch not found'], 404);
        }
    }


    public function update(BranchRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $branch = $this->saveBranch($validatedData);

            return response()->json($branch);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
    }

    public function destroy(Branch $branch): JsonResponse
    {
        try {
            $branch = Branch::where('id', $branch->id)->firstOrFail();
            $branch->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Branch not found'], 404);
        }
    }
}
