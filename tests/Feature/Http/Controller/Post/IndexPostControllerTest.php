<?php

namespace Tests\Feature\Http\Controller\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexPostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetPostList()
    {
        Post::factory()->count(10)->create();

        $response = $this->withHeader("Content-Type", "application/json")
            ->json("get", route("posts.index"));

        $response->assertStatus(200);
        $response->assertJsonCount(10, "data.*.title");
    }

    // access index with search by title
    public function testGetPostListWithSearchByTitle(){
        Post::factory()->count(10)->create();

        $post = Post::factory()->state([
            "title" => "test filter"
        ])->create();

        $response = $this->withHeader("Content-Type", "application/json")
            ->json("get", route("posts.index") . "?search=".$post->title);

        $response->assertStatus(200);
        $response->assertJsonCount(1, "data.*.title");
        $response->assertJson([
            "first_page_url" => route("posts.index") . "?search=".str_replace(" ", "%20", $post->title)."&page=1"
        ]);
    }

    // access index with filter by category
}
