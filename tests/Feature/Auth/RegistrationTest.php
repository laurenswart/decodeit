<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegistrationTest extends TestCase
{

    use DatabaseTransactions;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_teacher_can_register()
    {
        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'Teacher',
            'email' => 'new_teacher@example.com',
            'password' => 'epfcEPC123!',
            'password_confirmation' => 'epfcEPC123!',
            'isTeacher' => true,
            'terms' => true,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/verify-email');
    }

    public function test_new_student_can_register()
    {
        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'Student',
            'email' => 'new_student@example.com',
            'password' => 'epfcEPC123!',
            'password_confirmation' => 'epfcEPC123!',
            'terms' => true,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/verify-email');
    }

    public function test_cannot_register_with_duplicate_email()
    {
        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'Student1',
            'email' => 'duplicate@example.com',
            'password' => 'epfcEPC123!',
            'password_confirmation' => 'epfcEPC123!',
            'terms' => true,
        ]);
        $this->post('/logout');
        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'Student2',
            'email' => 'duplicate@example.com',
            'password' => 'epfcEPC123!',
            'password_confirmation' => 'epfcEPC123!',
            'terms' => true,
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function test_cannot_register_without_accepting_terms()
    {
        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'Terms',
            'email' => 'test_terms@example.com',
            'password' => 'epfcEPC123!',
            'password_confirmation' => 'epfcEPC123!',
        ]);

        $response->assertSessionHasErrors(['terms']);
    }
}
