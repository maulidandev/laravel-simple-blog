<?php

namespace Tests\Feature\Http\Controller\User;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->seed(UserSeeder::class);
    }

    public function testAccessCreatePage()
    {
        $response = $this->get(route("admin.users.create"));

        $response->assertStatus(200);
    }

    public function testCreateWithValidData(){
        $data = $this->getValidData();

        $response = $this->from(route("admin.users.create"))
            ->post(route("admin.users.store"), $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas("users", [
            "email" => $data["email"]
        ]);
        $response->assertRedirect(route("admin.users.index"));
    }

    /**
     * @dataProvider validationDataProvider
     */
    public function testInvalidData($errorFields, $inputFields){
        if (!is_array($inputFields))
            $inputFields = $inputFields();

        $data = $this->getValidData($inputFields);

        $response = $this->from(route("admin.users.create"))
            ->post(route("admin.users.store"), $data);

        $this->assertDatabaseCount("users", 0);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$errorFields]);
        $response->assertRedirect(route("admin.users.create"));
    }

    public function validationDataProvider(){
        return [
            ["name", ["name" => ""]],
            ["name", ["name" => str_repeat('John Thor ', 26)]],

            ["email", ["email" => ""]],
            ["email", ["email" => "johnthor"]],
            ["email", ["email_confirmation" => ""]],
            ["email", ["email_confirmation" => "johnthor"]],
            ["email", ["email_confirmation" => "johnthor@email.com"]],
            ["email", ["email_confirmation" => str_repeat("johnthor@email.com", 30)]],

            ["password", ["password" => ""]],
            ["password", ["password" => "123"]],
            ["password", ["password_confirmation" => ""]],
            ["password", ["password_confirmation" => "123"]],

            ["role", function(){
                return ["role" => Role::orderBy("id", "desc")->first()->id+1];
            }]
        ];
    }

    private function getValidData($overrides = []){
        $user = User::factory()->make();

        return array_merge([
            "name" => $user->name,
            "email" => $user->email,
            "email_confirmation" => $user->email,
            "password" => "password",
            "password_confirmation" => "password",
            "role" => $user->role_id
        ], $overrides);
    }
}
