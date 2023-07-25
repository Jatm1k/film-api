<?php


use App\Models\API\v1\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private array $userStructure = [
        'id',
        'name',
        'login',
        'email',
        'role',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
        $this->seed();
    }

    public function test_success_register(): void
    {
        $userData = [
            'name' => 'Ivan Ivanov',
            'login' => 'vanya',
            'email' => 'ivan@mail.ru',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->assertFalse(auth()->check());

        $response = $this->post('/register', $userData);

        $response
            ->assertStatus(201)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->userStructure);

        $this->assertTrue(auth()->check());
    }

    public function test_failed_register(): void
    {
        $user = User::factory()->createOne();
        auth()->login($user);
        $userData = [
            'name' => 'Ivan Ivanov',
            'login' => 'vanya',
            'email' => 'ivan@mail.ru',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->assertTrue(auth()->check());

        $response = $this->post('/register', $userData);

        $response
            ->assertStatus(422)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(['message' => __('auth.authenticated')]);

        $this->assertTrue(auth()->check());
    }

    public function test_success_login(): void
    {
        $user = User::factory()->createOne();

        $userData = [
            'login' => $user->login,
            'password' => 'password',
        ];

        $this->assertFalse(auth()->check());

        $response = $this->post('/login', $userData);

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->userStructure);

        $this->assertTrue(auth()->check());
    }

    public function test_failed_login(): void
    {
        $user = User::factory()->createOne();
        auth()->login($user);

        $this->assertTrue(auth()->check());

        $userData = [
            'login' => $user->login,
            'password' => 'password',
        ];

        $response = $this->post('/login', $userData);

        $response
            ->assertStatus(422)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(['message' => __('auth.authenticated')]);

        $this->assertTrue(auth()->check());
    }

    public function test_success_logout()
    {
        $user = User::factory()->createOne();
        auth()->login($user);

        $this->assertTrue(auth()->check());

        $response = $this->delete('/logout');

        $response
            ->assertNoContent();

        $this->assertFalse(auth()->check());
    }

    public function test_failed_logout()
    {
        $this->assertFalse(auth()->check());

        $response = $this->delete('/logout');

        $response
            ->assertStatus(401)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(['message' => __('auth.unauthenticated')]);

        $this->assertFalse(auth()->check());
    }
}
