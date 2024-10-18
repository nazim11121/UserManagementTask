<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Models\User;
use App\Services\UserManagementServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserManagementServiceInterface::class);
    }

    public function test_can_get_all_users()
    {
        User::factory()->count(2)->create();
        $users = $this->userService->getAllUsers();
        $this->assertCount(2, $users);
    }

    public function test_can_create_user()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123'
        ];

        $user = $this->userService->createUser($data);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();
        $data = ['name' => 'Jane Doe'];

        $this->userService->updateUser($user, $data);
        $this->assertDatabaseHas('users', ['name' => 'Jane Doe']);
    }

    public function test_can_soft_delete_user()
    {
        $user = User::factory()->create();
        $this->userService->deleteUser($user);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_can_restore_soft_deleted_user()
    {
        $user = User::factory()->create();
        $this->userService->deleteUser($user);

        $this->userService->restoreUser($user->id);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    public function test_can_permanently_delete_user()
    {
        $user = User::factory()->create();
        $this->userService->deleteUser($user);

        $this->userService->forceDeleteUser($user->id);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
