<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FilmResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
        Storage::fake();
    }

    public function test_film_index(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/films');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure([
                '*' => [
                    'title',
                    'production_year',
                    'duration',
                    'poster',
                    'images',
                    'trailer',
                ]
            ]);
    }

    public function test_film_show(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/films/1');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure([
                'title',
                'production_year',
                'duration',
                'poster',
                'images',
                'trailer',
            ]);
    }

    public function test_film_store(): void
    {
        $filmData = [
            'title' => 'Fight Club',
            'production_year' => 1999,
            'duration' => '02:19',
            'poster' => UploadedFile::fake()->image('fake-image.jpg'),
            'images' => [UploadedFile::fake()->image('fake-image2.jpg')],
            'trailer' => null,
        ];

        $response = $this->post('/api/v1/films', $filmData);

        $response
            ->assertCreated()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure([
                'title',
                'production_year',
                'duration',
                'poster',
                'images',
                'trailer',
            ]);

        $this->assertDatabaseHas('films', ['title' => $filmData['title']]);
    }
}
