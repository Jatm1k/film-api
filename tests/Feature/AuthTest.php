<?php


use App\Models\API\v1\Film;
use App\Models\API\v1\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
        Storage::fake('public');
    }

    public function test_register(): void
    {
        $userData = [
            'name' => 'Ivan Ivanov',
            'login' => 'vanya',
            'email' => 'ivan@mail.ru',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->assertFalse(auth()->check());

        $response = $this->post('/api/v1/register', $userData);

        $response
            ->assertStatus(201)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure(['token']);

        $this->assertTrue(auth()->check());
    }

    public function test_login(): void
    {
        $this->seed();
        $user = User::factory(1)->createOne();

        $userData = [
            'login' => $user->login,
            'password' => 'password',
        ];

        $this->assertFalse(auth()->check());

        $response = $this->post('/api/v1/login', $userData);

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure(['token']);

        $this->assertTrue(auth()->check());
    }
}
