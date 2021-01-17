<?php

namespace Tests\Unit\Services;

use App\Domains\Users\Models\User;
use App\Domains\Users\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private UserService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(UserService::class);
    }

    public function testItCanCreateAnNormalUser()
    {
        $data = [
            'name' => "{$this->faker->firstName} {$this->faker->lastName}",
            'email' => $this->faker->safeEmail,
            'password' => 'secret',
            'document' => '71001710717'
        ];

        $response = $this->service->create($data);

        unset($data['password']);

        $data = array_merge($data, [
            'document_type' => 'cpf'
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(User::class, $response);
        $this->assertDatabaseHas('users', $data);
    }

    public function testItCanCreateAnSellerUser()
    {
        $data = [
            'name' => "{$this->faker->firstName} {$this->faker->lastName}",
            'email' => $this->faker->safeEmail,
            'password' => 'secret',
            'document' => '71001710717234'
        ];

        $response = $this->service->create($data);

        unset($data['password']);

        $data = array_merge($data, [
            'document_type' => 'cnpj'
        ]);

        $this->assertNotNull($response);
        $this->assertInstanceOf(User::class, $response);
        $this->assertDatabaseHas('users', $data);
    }

    public function testItCanUpdateAnUser()
    {
        $user = User::factory()->create();

        $data = User::factory()->make([
            'id' => $user->id,
            'document' => $user->document,
            'document_type' => $user->document_type,
        ]);

        $response = $this->service->update($user, $data->toArray());

        $this->assertNotNull($response);
        $this->assertEquals(true, (bool) $response);
        $this->assertDatabaseHas('users', [
            'name' => $data->name,
            'email' => $data->email,
        ]);
    }

    public function testItCanDeleteAnUser()
    {
        $user = User::factory()->create();

        $response = $this->service->destroy($user, $user);

        $this->assertNotNull($response);
        $this->assertEquals(true, (bool) $response);
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);
    }

    public function testItCanNotDeleteAnUser()
    {
        $user = User::factory()->create();

        $response = $this->service->destroy($this->user, $user);

        $this->assertNotNull($response);
        $this->assertEquals(false, (bool) $response);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }
}
