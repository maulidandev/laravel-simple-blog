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

        $response = $this->get(route("posts.index"));

        $response->assertStatus(200);
    }
}
