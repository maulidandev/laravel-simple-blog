<?php

namespace Tests\Feature\Http\Controller\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletePostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeletePost()
    {
        $post = Post::factory()->create();
        $this->assertDatabaseHas("posts", ["id" => $post->id]);

        $response = $this->from(route("posts.index", $post->id))
            ->post(route("posts.destroy", $post->id), [
                "_method" => "delete"
            ]);

        $this->assertDatabaseCount("posts", 0);

        $response->assertStatus(302);
        $response->assertRedirect(route("posts.index"));
    }
}
