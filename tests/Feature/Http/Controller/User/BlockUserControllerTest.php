<?php

namespace Tests\Feature\Http\Controller\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlockUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBlockUser()
    {
        $user = User::factory()->create();
        $response = $this->post(route("admin.users.block", $user->id));

        $response->assertStatus(302);
        $response->assertRedirect(route("admin.users.index"));
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "is_block" => 1
        ]);
    }

    public function testUnBlockUser()
    {
        $user = User::factory()->create([
            "is_block" => 1
        ]);
        $response = $this->post(route("admin.users.block", $user->id));

        $response->assertStatus(302);
        $response->assertRedirect(route("admin.users.index"));
        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "is_block" => 0
        ]);
    }

    public function testInvalidID()
    {
        $response = $this->post(route("admin.users.block", 1));

        $response->assertStatus(404);
    }
}
