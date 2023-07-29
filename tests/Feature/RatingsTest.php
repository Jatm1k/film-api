<?php


use App\Models\API\v1\Film;
use App\Models\API\v1\Rating;
use App\Models\API\v1\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingsTest extends TestCase
{
    use RefreshDatabase;

    private array $ratingStructure = [
        'id',
        'author',
        'film',
        'rating',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
        $this->seed();
    }

    public function test_success_store_rating(): void
    {
        $user = User::factory()->createOne();
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $ratingData = [
            'rating' => rand(1, 10),
            'film_id' => $film->id,
        ];

        $response = $this->post("/api/v1/ratings", $ratingData);

        $response
            ->assertStatus(201)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->ratingStructure);

        $this->assertDatabaseHas('ratings', $ratingData);
    }

    public function test_failed_store_rating(): void
    {
        $this->assertFalse(auth()->check());

        $film = Film::factory()->createOne();

        $ratingData = [
            'rating' => rand(1, 10),
            'film_id' => $film->id,
        ];

        $response = $this->post("/api/v1/ratings", $ratingData);

        $response
            ->assertUnauthorized()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'message' => __('auth.unauthenticated'),
            ]);

        $this->assertDatabaseMissing('ratings', $ratingData);
    }

    public function test_success_update_rating()
    {
        $rating = Rating::factory()->createOne();

        auth()->loginUsingId($rating->user_id);
        $this->assertTrue(auth()->check());

        $ratingData = [
            'rating' => rand(1, 10),
        ];

        $response = $this->patch("/api/v1/ratings/{$rating->id}", $ratingData);

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('response.message.updated'),
            ]);

        $this->assertDatabaseHas('ratings', $ratingData);
        $this->assertDatabaseMissing('ratings', $rating->toArray());
    }

    public function test_success_destroy_rating()
    {
        $rating = Rating::factory()->createOne();

        auth()->loginUsingId($rating->user_id);
        $this->assertTrue(auth()->check());

        $response = $this->delete("/api/v1/ratings/{$rating->id}");

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('response.message.destroyed'),
            ]);

        $this->assertDatabaseMissing('ratings', $rating->toArray());
    }
}
