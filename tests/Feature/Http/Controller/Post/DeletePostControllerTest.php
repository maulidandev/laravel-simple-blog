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

        $response = $this->from(route("posts.index", $post->id))
            ->post(route("posts.destroy", $post->id), [
                "_method" => "delete"
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("posts.index"));
    }
}
