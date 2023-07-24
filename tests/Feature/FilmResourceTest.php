<?php

namespace Tests\Feature;

use App\Models\API\v1\Film;
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
        Storage::fake('public');
    }

    public function test_film_index(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/films');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure(['*' => $this->filmStructure]);
    }

    public function test_film_show(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/films/1');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->filmStructure);
    }

    public function test_film_store(): void
    {
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

    public function test_film_update(): void
    {
        $film = Film::factory(1)->create()->first();

        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => UploadedFile::fake()->image('fake-image.jpg'),
            'images' => [UploadedFile::fake()->image('fake-image2.jpg')],
            'trailer' => null,
        ];

        $response = $this->put('/api/v1/films/1', $filmData);

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => true
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
}
