<?php

namespace Tests\Feature;

use App\Models\Branch;
use Tests\TestCase;

class BranchControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->get('/api/branches');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'name' => 'John Doe',
            'location' => 'Test Name',
        ];

        $response = $this->post('/api/branches', $data);

        $response->assertStatus(201);
    }

    public function testShow()
    {
        $branch = Branch::factory()->create();

        $response = $this->get('/api/branches/' . $branch->id);

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $branch = Branch::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'location' => 'Test Name',
        ];

        $response = $this->put('/api/branches/' . $branch->id, $data);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $branch = Branch::factory()->create();

        $response = $this->delete('/api/branches/' . $branch->id);

        $response->assertStatus(204);
    }
}
