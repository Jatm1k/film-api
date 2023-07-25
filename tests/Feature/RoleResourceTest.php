<?php


use App\Models\API\v1\Film;
use App\Models\API\v1\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoleResourceTest extends TestCase
{
    use RefreshDatabase;

    private array $roleStructure = [
        'name'
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();

        $user = \App\Models\API\v1\User::factory()->createOne(['role_id' => \App\Enums\API\v1\Role::Admin->getId()]);
        auth()->login($user);
    }

    public function test_role_index(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/roles');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure(['*' => $this->roleStructure]);
    }

    public function test_role_show(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/roles/1');

        $response
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->roleStructure);
    }

    public function test_role_store(): void
    {
        $roleData = [
            'name' => 'viewer',
        ];

        $response = $this->post('/api/v1/roles', $roleData);


        $response
            ->assertCreated()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure($this->roleStructure);

        $this->assertDatabaseHas('roles', ['name' => $roleData['name']]);
    }

    public function test_role_update(): void
    {
        $role = Role::factory(1)->create()->first();

        $roleData = [
            'name' => 'viewer',
        ];

        $response = $this->put('/api/v1/roles/1', $roleData);

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson([
                'status' => true
            ]);

        $this->assertDatabaseMissing(
            'roles',
            [
                'name' => $role->name,
            ]
        );

        $this->assertDatabaseHas(
            'roles',
            [
                'name' => $roleData['name'],
            ]
        );
    }
}
