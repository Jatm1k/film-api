<?php

namespace Tests\Feature;

use App\Enums\API\v1\Role;
use App\Models\API\v1\Film;
use App\Models\API\v1\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FilmResourceTest extends TestCase
{
    use RefreshDatabase;

    private array $filmStructure = [
        'title',
        'production_year',
        'duration',
        'poster',
        'images',
        'trailer',
    ];

    private array $filmMinifiedStructure = [
        'title',
        'production_year',
        'duration',
        'poster',
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

        $film = Film::factory(1)->create()->first();

        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => UploadedFile::fake()->image('fake-image.jpg'),
            'images' => [UploadedFile::fake()->image('fake-image2.jpg')],
            'trailer' => null,
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

        $film = Film::factory(1)->create()->first();

        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => UploadedFile::fake()->image('fake-image.jpg'),
            'images' => [UploadedFile::fake()->image('fake-image2.jpg')],
            'trailer' => null,
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

        $film = Film::factory(1)->create()->first();

        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => UploadedFile::fake()->image('fake-image.jpg'),
            'images' => [UploadedFile::fake()->image('fake-image2.jpg')],
            'trailer' => null,
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

        $film = Film::factory(1)->create()->first();

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

        $film = Film::factory(1)->create()->first();

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

        $film = Film::factory(1)->create()->first();

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
}
