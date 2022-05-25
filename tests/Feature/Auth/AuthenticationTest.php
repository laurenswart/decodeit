<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_student_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'epfcEPFC123!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/student/dashboard');
    }

    public function test_teacher_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->role('teacher')->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'epfcEPFC123!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/teacher/dashboard');
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
