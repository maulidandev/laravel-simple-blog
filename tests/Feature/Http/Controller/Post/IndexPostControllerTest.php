<?php

namespace Tests\Feature\Http\Controller\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexPostControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetPostList()
    {
        $response = $this->get(route("posts.index"));

        $response->assertStatus(200);
    }
}
