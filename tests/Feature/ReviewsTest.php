<?php


use App\Enums\API\v1\ReviewType;
use App\Models\API\v1\Film;
use App\Models\API\v1\Review;
use App\Models\API\v1\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewsTest extends TestCase
{
    use RefreshDatabase;

    private array $reviewStructure = [
        'id',
        'title',
        'text',
        'type',
        'author',
        'film',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
        $this->seed();
    }

    public function test_success_store_review(): void
    {
        $user = User::factory()->createOne();
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $reviewData = [
            'title' => fake()->word(),
            'text' => fake()->text(),
            'type' => fake()->randomElement(ReviewType::cases())->value,
            'film_id' => $film->id,
        ];

        $response = $this->post("/api/v1/reviews", $reviewData);

        $response
            ->assertStatus(201)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->reviewStructure);

        $this->assertDatabaseHas('reviews', $reviewData);
    }

    public function test_failed_store_review(): void
    {
        $this->assertFalse(auth()->check());

        $film = Film::factory()->createOne();

        $reviewData = [
            'title' => fake()->word(),
            'text' => fake()->text(),
            'type' => fake()->randomElement(ReviewType::cases())->value,
            'film_id' => $film->id,
        ];

        $response = $this->post("/api/v1/reviews", $reviewData);

        $response
            ->assertUnauthorized()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'message' => __('auth.unauthenticated'),
            ]);

        $this->assertDatabaseMissing('reviews', $reviewData);
    }

    public function test_success_update_review()
    {
        $review = Review::factory()->createOne();

        auth()->loginUsingId($review->user_id);
        $this->assertTrue(auth()->check());

        $reviewData = [
            'title' => fake()->word(),
            'text' => fake()->text(),
            'type' => fake()->randomElement(ReviewType::cases())->value,
        ];

        $response = $this->patch("/api/v1/reviews/{$review->id}", $reviewData);

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('response.message.updated'),
            ]);

        $this->assertDatabaseHas('reviews', $reviewData);
        $this->assertDatabaseMissing('reviews', $review->toArray());
    }

    public function test_success_destroy_review()
    {
        $review = Review::factory()->createOne();

        auth()->loginUsingId($review->user_id);
        $this->assertTrue(auth()->check());

        $response = $this->delete("/api/v1/reviews/{$review->id}");

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('response.message.destroyed'),
            ]);

        $this->assertDatabaseMissing('reviews', $review->toArray());
    }
}
