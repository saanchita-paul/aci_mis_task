<?php
namespace Tests\Unit;

use App\Models\User;
use App\Services\Auth\UserLoginService;
use App\Services\Auth\UserRegisterService;
use App\Services\Auth\UserLogoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserAuthServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user()
    {
        $service = new UserRegisterService();

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $result = $service->register($data);

        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('token', $result);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_login_user_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('secret'),
        ]);

        $service = new UserLoginService();

        $credentials = [
            'email' => 'login@example.com',
            'password' => 'secret',
        ];

        $result = $service->login($credentials);

        $this->assertArrayHasKey('user', $result);
        $this->assertEquals($user->id, $result['user']->id);
        $this->assertArrayHasKey('token', $result);
    }

    public function test_login_fails_with_wrong_password()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        User::factory()->create([
            'email' => 'wrong@example.com',
            'password' => bcrypt('correct'),
        ]);

        $service = new UserLoginService();
        $service->login([
            'email' => 'wrong@example.com',
            'password' => 'incorrect',
        ]);
    }

    public function test_logout_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api_token')->plainTextToken;

        $request = Request::create('/api/v1/logout', 'POST');
        $request->setUserResolver(fn () => $user);

        $service = new UserLogoutService();
        $service->logout($request);

        $this->assertCount(0, $user->tokens);
    }
}
