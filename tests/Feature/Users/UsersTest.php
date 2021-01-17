<?php

namespace Tests\Feature\Users;

use App\Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testItCanCreateAnNormalUser()
    {
        $data = [
            'name' => "{$this->faker->firstName} {$this->faker->lastName}",
            'email' => $this->faker->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'document' => '71001710717',
        ];

        $response = $this->postJson(route('users.store'), $data);

        unset($data['password'], $data['password_confirmation']);

        $data = array_merge($data, [
            'document_type' => 'cpf'
        ]);

        $this->assertNotNull($response);
        $this->assertDatabaseHas('users', $data);
    }

    public function testItCanCreateAnSellerUser()
    {
        $data = [
            'name' => "{$this->faker->firstName} {$this->faker->lastName}",
            'email' => $this->faker->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'document' => '71001710717325',
        ];

        $response = $this->postJson(route('users.store'), $data);

        unset($data['password'], $data['password_confirmation']);

        $data = array_merge($data, [
            'document_type' => 'cnpj'
        ]);

        $this->assertNotNull($response);
        $this->assertDatabaseHas('users', $data);
    }

    public function testItCanUpdateAnUser()
    {
        Sanctum::actingAs($this->user);

        $data = User::factory()->make([
            'id' => $this->user->id,
            'document' => $this->user->document,
            'document_type' => $this->user->document_type,
        ]);

        $response = $this->putJson(route('users.update', $this->user->id), $data->toArray());

        $this->assertNotNull($response);
        $this->assertEquals(true, (bool) $response->json('success'));
        $this->assertDatabaseHas('users', [
            'name' => $data->name,
            'email' => $data->email,
        ]);
    }

    public function testItCanDeleteAnUser()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson(route('users.destroy', $this->user));

        $this->assertEquals(true, (bool) $response->json('success'));
        $this->assertSoftDeleted('users', [
            'id' => $this->user->id,
        ]);
    }
}
