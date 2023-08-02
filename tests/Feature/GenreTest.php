<?php

use App\Models\API\v1\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class GenreTest extends TestCase
{

    use RefreshDatabase;

    private array $genreStructure = [
        'name',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();

        $user = \App\Models\API\v1\User::factory()
            ->createOne(['role_id' => \App\Enums\API\v1\Role::Admin->getId()]);
        auth()->login($user);
    }

    public function test_genre_index(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/genres');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure(['*' => $this->genreStructure]);
    }

    public function test_genre_show(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/genres/1');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->genreStructure);
    }

    public function test_genre_store(): void
    {
        $genreData = [
            'name' => fake()->word(),
        ];

        $response = $this->post('/api/v1/genres', $genreData);

        $response
            ->assertCreated()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->genreStructure);

        $this->assertDatabaseHas('genres', $genreData);
    }

    public function test_genre_update(): void
    {
        $genre = Genre::factory()->createOne();

        $genreData = [
            'name' => fake()->unique()->word(),
        ];

        $response = $this->put("/api/v1/genres/{$genre->id}", $genreData);

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => true,
            ]);

        $this->assertDatabaseMissing(
            'genres',
            [
                'name' => $genre->name,
            ]
        );

        $this->assertDatabaseHas(
            'genres',
            [
                'name' => $genreData['name'],
            ]
        );
    }

    public function test_genre_destroy(): void
    {
        $genre = Genre::factory()->createOne();

        $response = $this->delete("/api/v1/genres/{$genre->id}");

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('response.message.destroyed'),
            ]);

        $this->assertDatabaseMissing(
            'genres',
            [
                'id' => $genre->id,
            ]
        );
    }

}
