<?php

namespace Tests\Feature\Http\Controller\Post;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditPostControllerTest extends TestCase
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
        $post = Post::factory()->create();
        $category = Category::factory()->create();

        $this->assertDatabaseHas("posts", ["id" => $post->id]);
        $this->assertDatabaseHas("categories", ["id" => $category->id]);

        $data = [
            "title" => $this->faker->words(3, true),
            "category_id" => $category->id,
            "content" => $this->faker->text,
            "_method" => "put",
        ];

        $response = $this->from(route("posts.edit", $post->id))
            ->post(route("posts.update", $post->id), $data);

        unset($data["_method"]);
        $this->assertDatabaseHas("posts", $data);

        $response->assertStatus(302);
        $response->assertRedirect(route("posts.index"));
    }

    public function testUsingInvalidData()
    {
        $post = Post::factory()->create();
        $category = Category::factory()->create();

        $this->assertDatabaseHas("posts", ["id" => $post->id]);
        $this->assertDatabaseHas("categories", ["id" => $category->id]);

        $data = [
            "title" => $this->faker->words(500, true),
            "category_id" => $category->id,
            "content" => $this->faker->text,
            "_method" => "put",
        ];

        $response = $this->from(route("posts.edit", $post->id))
            ->post(route("posts.update", $post->id), $data);

        unset($data["_method"]);
        $this->assertDatabaseMissing("posts", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(["title"]);
        $response->assertRedirect(route("posts.edit", $post->id));
    }

    public function testUsingNotUniqueTitle()
    {
        $post = Post::factory()->create();
        $category = Category::factory()->create();

        $this->assertDatabaseHas("posts", ["id" => $post->id]);
        $this->assertDatabaseHas("categories", ["id" => $category->id]);

        $data = [
            "title" => $this->faker->words(500, true),
            "category_id" => $category->id,
            "content" => $this->faker->text,
            "_method" => "put",
        ];

        $response = $this->from(route("posts.edit", $post->id))
            ->post(route("posts.update", $post->id), $data);

        unset($data["_method"]);
        $this->assertDatabaseMissing("posts", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(["title"]);
        $response->assertRedirect(route("posts.edit", $post->id));
    }
}
