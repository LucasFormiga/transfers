<?php

namespace Tests\Unit\Requests;

use App\Domains\Users\Requests\UpdateUserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testItReturnsTheSameUpdateUserRequestRules()
    {
        $request = new UpdateUserRequest();

        $this->assertIsArray($request->rules());

        $this->assertEquals([
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'password' => 'nullable|password_confirmation',
        ], $request->rules());
    }
}
