<?php

namespace Tests\Feature;

use App\Models\Employee;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->get('/api/employees');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'name' => 'John Doe',
            'branch_id' => 5,
        ];

        $response = $this->post('/api/employees', $data);

        $response->assertStatus(201);
    }

    public function testShow()
    {
        $employee = Employee::factory()->create();

        $response = $this->get('/api/employees/' . $employee->id);

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $employee = Employee::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'branch_id' => 5,
        ];

        $response = $this->put('/api/employees/' . $employee->id, $data);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $employee = Employee::factory()->create();

        $response = $this->delete('/api/employees/' . $employee->id);

        $response->assertStatus(204);
    }
}
