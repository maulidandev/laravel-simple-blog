<?php

namespace Tests\Feature\Http\Controller\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas("users", ["id" => $user->id]);

        $response = $this->from(route("admin.users.index", $user->id))
            ->post(route("admin.users.destroy", $user->id), [
                "_method" => "delete"
            ]);

        $this->assertDatabaseCount("users", 0);

        $response->assertStatus(302);
        $response->assertRedirect(route("admin.users.index"));
    }

    /**
     * delete invalid id (id not exists)
     */
    public function testUsingInvalidID(){
        $this->assertDatabaseMissing("users", ["id" => 1]);

        $response = $this->json("delete", route("admin.users.destroy", 1));

        $response->assertStatus(404);
    }
}
