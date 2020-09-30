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
                "title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae interdum arcu. Quisque sagittis venenatis massa in lobortis. Morbi pretium aliquet arcu vitae volutpat. Aliquam blandit feugiat ultricies. Quisque rutrum pulvinar bibendum. Maecenas sollicitudin lectus sit amet venenatis viverra. Cras sit amet gravida arcu. Nulla semper bibendum fermentum. Praesent a elit gravida dolor tempor tempor eu non neque. Cras efficitur lorem ut nulla dictum hendrerit.",
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
