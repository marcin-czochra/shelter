<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    private function saveEmployee(array $data): Employee
    {
        $employee = new Employee();
        $employee->name = $data['name'];
        $employee->branch_id = $data['branch_id'];
        $employee->save();

        return $employee;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Employee::with('branch');

        // Filtering
        if ($request->has('branch_ids')) {
            $branchIds = $request->input('branch_ids');
            $query->whereIn('branch_id', $branchIds);
        }

        // Sorting
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $employees = $query->paginate(10);
        return response()->json($employees);
    }

    public function store(EmployeeRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $employee = $this->saveEmployee($validatedData);

            return response()->json($employee, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
    }


    public function show(Employee $employee): JsonResponse
    {
        try {
            $employee = Employee::with('branch')->where('id', $employee->id)->firstOrFail();
            return response()->json($employee);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }


    public function update(EmployeeRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $employee = $this->saveEmployee($validatedData);

            return response()->json($employee);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
    }

    public function destroy(Employee $employee): JsonResponse
    {
        try {
            $employee = Employee::with('branch')->where('id', $employee->id)->firstOrFail();
            $employee->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }
}
