<?php

namespace Tests\Feature;

use App\Models\Cat;
use Tests\TestCase;

class CatControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->get('/api/cats');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'name' => 'Miau',
            'branch_id' => 5,
        ];

        $response = $this->post('/api/cats', $data);

        $response->assertStatus(201);
    }

    public function testShow()
    {
        $cat = Cat::factory()->create();

        $response = $this->get('/api/cats/' . $cat->id);

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $cat = Cat::factory()->create();

        $data = [
            'name' => 'Miau',
            'branch_id' => 5,
        ];

        $response = $this->put('/api/cats/' . $cat->id, $data);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $cat = Cat::factory()->create();

        $response = $this->delete('/api/cats/' . $cat->id);

        $response->assertStatus(204);
    }
}
