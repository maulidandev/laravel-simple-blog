<?php

namespace Tests\Feature\Http\Controller\Post;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUsingValidData()
    {
        $category = Category::factory()->create();

        $response = $this->from(route("posts.create"))
            ->post(route("posts.store"), [
                "title" => $this->faker->words(3, true),
                "category_id" => $category->id,
                "content" => $this->faker->text
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("posts.index"));
    }

    public function testUsingInvalidTitle(){
        $category = Category::factory()->create();

        $response = $this->from(route("posts.create"))
            ->post(route("posts.store"), [
                "title" => $this->faker->words(500, true),
                "category_id" => $category->id,
                "content" => $this->faker->text
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("posts.create"));
    }

    public function testUsingNotUniqeTitle(){
        $post = Post::factory()->create();
        $category = Category::factory()->create();

        $response = $this->from(route("posts.create"))
            ->post(route("posts.store"), [
                "title" => $post->title,
                "category_id" => $category->id,
                "content" => $this->faker->text
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("posts.create"));
    }
}
