<?php

namespace Tests\Feature;

use App\Enums\API\v1\Role;
use App\Models\API\v1\Film;
use App\Models\API\v1\Genre;
use App\Models\API\v1\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    private array $filmStructure = [
        'id',
        'title',
        'production_year',
        'duration',
        'poster',
        'images',
        'trailer',
        'rating',
        'genres',
    ];

    private array $filmMinifiedStructure = [
        'id',
        'title',
        'production_year',
        'duration',
        'poster',
        'rating',
        'genres',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
        Storage::fake('public');
        $this->seed();
    }

    public function test_film_index(): void
    {
        $response = $this->get('/api/v1/films');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure(['*' => $this->filmMinifiedStructure]);
    }

    public function test_user_watched()
    {
        auth()->loginUsingId(1);
        $this->assertTrue(auth()->check());

        $response = $this->get('/api/v1/watched');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure(['*' => $this->filmMinifiedStructure]);
    }

    public function test_user_favorite()
    {
        auth()->loginUsingId(1);
        $this->assertTrue(auth()->check());

        $response = $this->get('/api/v1/favorite');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure(['*' => $this->filmMinifiedStructure]);
    }

    public function test_film_show(): void
    {
        $response = $this->get('/api/v1/films/1');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->filmStructure);
    }

    public function test_film_success_admin_store(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Admin->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $filmPoster = UploadedFile::fake()->image('fake-poster.jpg');
        $filmImages = [
            UploadedFile::fake()->image('fake-image1.jpg'),
            UploadedFile::fake()->image('fake-image2.jpg'),
            UploadedFile::fake()->image('fake-image3.jpg'),
        ];
        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => $filmPoster,
            'images' => $filmImages,
            'trailer' => null,
            'genres' => Genre::get()->random(3)->pluck('id')->toArray()
        ];

        $response = $this->post('/api/v1/films', $filmData);


        $response
            ->assertCreated()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->filmStructure);

        $this->assertDatabaseHas('films', ['title' => $filmData['title']]);
    }

    public function test_film_failed_user_store(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Viewer->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $filmPoster = UploadedFile::fake()->image('fake-poster.jpg');
        $filmImages = [
            UploadedFile::fake()->image('fake-image1.jpg'),
            UploadedFile::fake()->image('fake-image2.jpg'),
            UploadedFile::fake()->image('fake-image3.jpg'),
        ];
        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => $filmPoster,
            'images' => $filmImages,
            'trailer' => null,
            'genres' => Genre::get()->random(3)->pluck('id')->toArray()
        ];

        $response = $this->post('/api/v1/films', $filmData);


        $response
            ->assertForbidden()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(['message' => __('auth.forbidden')]);

        $this->assertDatabaseMissing('films', ['title' => $filmData['title']]);
    }

    public function test_film_failed_no_login_store(): void
    {
        $this->assertFalse(auth()->check());

        $filmPoster = UploadedFile::fake()->image('fake-poster.jpg');
        $filmImages = [
            UploadedFile::fake()->image('fake-image1.jpg'),
            UploadedFile::fake()->image('fake-image2.jpg'),
            UploadedFile::fake()->image('fake-image3.jpg'),
        ];
        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => $filmPoster,
            'images' => $filmImages,
            'trailer' => null,
            'genres' => Genre::get()->random(3)->pluck('id')->toArray()
        ];

        $response = $this->post('/api/v1/films', $filmData);


        $response
            ->assertUnauthorized()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(['message' => __('auth.unauthenticated')]);

        $this->assertDatabaseMissing('films', ['title' => $filmData['title']]);
    }

    public function test_film_success_admin_update(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Admin->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => UploadedFile::fake()->image('fake-image.jpg'),
            'images' => [UploadedFile::fake()->image('fake-image2.jpg')],
            'trailer' => null,
            'genres' => Genre::get()->random(3)->pluck('id')->toArray()
        ];

        $response = $this->put("/api/v1/films/{$film->id}", $filmData);

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('response.message.updated'),
            ]);

        $this->assertDatabaseMissing(
            'films',
            [
                'title' => $film->title,
            ]
        );

        $this->assertDatabaseHas(
            'films',
            [
                'title' => $filmData['title'],
            ]
        );
    }

    public function test_film_failed_user_update(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Viewer->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => UploadedFile::fake()->image('fake-image.jpg'),
            'images' => [UploadedFile::fake()->image('fake-image2.jpg')],
            'trailer' => null,
            'genres' => Genre::get()->random(3)->pluck('id')->toArray()
        ];

        $response = $this->put("/api/v1/films/{$film->id}", $filmData);

        $response
            ->assertForbidden()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(['message' => __('auth.forbidden')]);

        $this->assertDatabaseHas(
            'films',
            [
                'title' => $film->title,
            ]
        );

        $this->assertDatabaseMissing(
            'films',
            [
                'title' => $filmData['title'],
            ]
        );
    }

    public function test_film_failed_no_login_update(): void
    {
        $this->assertFalse(auth()->check());

        $film = Film::factory()->createOne();

        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => UploadedFile::fake()->image('fake-image.jpg'),
            'images' => [UploadedFile::fake()->image('fake-image2.jpg')],
            'trailer' => null,
            'genres' => Genre::get()->random(3)->pluck('id')->toArray()
        ];

        $response = $this->put("/api/v1/films/{$film->id}", $filmData);

        $response
            ->assertUnauthorized()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(['message' => __('auth.unauthenticated')]);

        $this->assertDatabaseHas(
            'films',
            [
                'title' => $film->title,
            ]
        );

        $this->assertDatabaseMissing(
            'films',
            [
                'title' => $filmData['title'],
            ]
        );
    }

    public function test_film_success_admin_destroy(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Admin->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $response = $this->delete("/api/v1/films/{$film->id}");

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('response.message.destroyed'),
            ]);

        $this->assertDatabaseMissing(
            'films',
            [
                'id' => $film->id,
            ]
        );
    }

    public function test_film_failed_user_destroy(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Viewer->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $response = $this->delete("/api/v1/films/{$film->id}");

        $response
            ->assertForbidden()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'message' => __('auth.forbidden'),
            ]);

        $this->assertDatabaseHas(
            'films',
            [
                'id' => $film->id,
            ]
        );
    }

    public function test_film_failed_no_login_destroy(): void
    {
        $this->assertFalse(auth()->check());

        $film = Film::factory()->createOne();

        $response = $this->delete("/api/v1/films/{$film->id}");

        $response
            ->assertUnauthorized()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'message' => __('auth.unauthenticated'),
            ]);

        $this->assertDatabaseHas(
            'films',
            [
                'id' => $film->id,
            ]
        );
    }

    public function test_film_watch(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Viewer->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $response = $this->post("/api/v1/films/{$film->id}/watch");

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('film.message.watch'),
            ]);

        $this->assertDatabaseHas(
            'film_user_watched',
            [
                'film_id' => $film->id,
                'user_id' => $user->id,
            ]
        );
    }

    public function test_film_unwatch(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Viewer->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $response = $this->post("/api/v1/films/{$film->id}/watch");

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('film.message.watch'),
            ]);

        $this->assertDatabaseHas(
            'film_user_watched',
            [
                'film_id' => $film->id,
                'user_id' => $user->id,
            ]
        );

        $response = $this->delete("/api/v1/films/{$film->id}/unwatch");

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('film.message.unwatch'),
            ]);

        $this->assertDatabaseMissing(
            'film_user_watched',
            [
                'film_id' => $film->id,
                'user_id' => $user->id,
            ]
        );
    }

    public function test_film_favorite(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Viewer->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $response = $this->post("/api/v1/films/{$film->id}/favorite");

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('film.message.favorite'),
            ]);

        $this->assertDatabaseHas(
            'film_user_favorite',
            [
                'film_id' => $film->id,
                'user_id' => $user->id,
            ]
        );
    }

    public function test_film_unfavorite(): void
    {
        $user = User::factory()->createOne(['role_id' => Role::Viewer->getId()]);
        auth()->login($user);
        $this->assertTrue(auth()->check());

        $film = Film::factory()->createOne();

        $response = $this->post("/api/v1/films/{$film->id}/favorite");

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('film.message.favorite'),
            ]);

        $this->assertDatabaseHas(
            'film_user_favorite',
            [
                'film_id' => $film->id,
                'user_id' => $user->id,
            ]
        );

        $response = $this->delete("/api/v1/films/{$film->id}/unfavorite");

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => __('response.status.success'),
                'message' => __('film.message.unfavorite'),
            ]);

        $this->assertDatabaseMissing(
            'film_user_favorite',
            [
                'film_id' => $film->id,
                'user_id' => $user->id,
            ]
        );
    }
}
