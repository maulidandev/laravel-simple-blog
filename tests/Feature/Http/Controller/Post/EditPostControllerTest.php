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
        $data = $this->getEditPostData();

        $this->assertDatabaseHas("posts", [
            "id" => $post->id,
            "title" => $post->title,
            "category_id" => $post->category_id,
            "content" => $post->content,
        ]);

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
        $data = $this->getEditPostData(["title" => $this->faker->words(500, true)]);

        $this->assertDatabaseHas("posts", [
            "id" => $post->id,
            "title" => $post->title,
            "category_id" => $post->category_id,
            "content" => $post->content,
        ]);

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
        $posts = Post::factory(2)->create();

        foreach ($posts as $post)
            $this->assertDatabaseHas("posts", [
                "title" => $post->title,
            ]);

        $data = $this->getEditPostData(["title" => $posts[1]]);

        $response = $this->from(route("posts.edit", $posts[0]->id))
            ->post(route("posts.update", $posts[0]->id), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(["title"]);
        $response->assertRedirect(route("posts.edit", $posts[0]->id));
    }

    private function getEditPostData($overrides = []){
        $category = Category::factory()->create();

        return array_merge([
            "title" => $this->faker->words(3, true),
            "category_id" => $category->id,
            "content" => $this->faker->text,
            "_method" => "put",
        ], $overrides);
    }
}
