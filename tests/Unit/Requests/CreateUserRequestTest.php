<?php

namespace Tests\Unit\Requests;

use App\Domains\Users\Requests\CreateUserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testItReturnsTheSameCreateUserRequestRules()
    {
        $request = new CreateUserRequest();

        $this->assertIsArray($request->rules());

        $this->assertEquals([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'document' => 'required|string|unique:users,document',
        ], $request->rules());
    }
}
