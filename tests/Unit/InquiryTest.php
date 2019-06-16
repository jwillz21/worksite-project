<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InquiryTest extends TestCase
{
    /**
     *  Test null name to http request
     *
     * @return void
     */
    public function testNullName()
    {
      $response = $this->json('POST', '/api/inquiry', [
       'phone' => '123456789', 'email' => "email@email.com", 'message' => "cmon man"]);
      $response
      ->assertStatus(400)
       ->assertJson([
           'nameError' => "This field is required",
        ]);
    }
    /**
     *  Test null email to http request
     *
     * @return void
     */
    public function testNullEmail()
    {
      $response = $this->json('POST', '/api/inquiry', ['name' => 'bob',
       'phone' => '123456789',  'message' => "cmon man"]);
      $response
      ->assertStatus(400)
       ->assertJson([
           'emailError' => "This field is required",
        ]);
    }

    /**
     *  Test null phone to http request
     *
     * @return void
     */
    public function testNullPhone()
    {
      $response = $this->json('POST', '/api/inquiry', ['name' => 'bob',
      'email' => "email@email.com", 'message' => "cmon man"]);
      $response
      ->assertStatus(400)
       ->assertJson([
           'phoneError' => "This field is required",
        ]);
    }

    /**
     *  Test null message to http request
     *
     * @return void
     */
    public function testNullMessage()
    {
      $response = $this->json('POST', '/api/inquiry', ['name' => Str::random(10),
       'phone' => '123456789', 'email' => Str::random(5)."@".Str::random(10). ".com"]);
      $response
      ->assertStatus(400)
       ->assertJson([
           'messageError' => "This field is required",
        ]);
    }

    /**
     *  Test null message to http request
     *
     * @return void
     */
    public function testMessageLength()
    {
      $response = $this->json('POST', '/api/inquiry', ['name' => Str::random(10),
       'phone' => '123456789', 'email' => Str::random(5)."@".Str::random(10). ".com",
        'message' => Str::random(501)]);
      $response
      ->assertStatus(400)
       ->assertJson([
           'messageError' => 'Character limit of 500 exceeded',
        ]);
    }
    public function testEmailLength()
    {
      $response = $this->json('POST', '/api/inquiry', ['name' => Str::random(10),
       'phone' => '123456789', 'email' => Str::random(51), 'message' => Str::random(450)]);
      $response
      ->assertStatus(400)
       ->assertJson([
           'emailError' => 'Character limit of 50 exceeded',
        ]);
    }
    public function testNameLength()
    {
      $response = $this->json('POST', '/api/inquiry', ['name' => Str::random(51),
       'phone' => '123456789', 'email' => Str::random(5)."@".Str::random(10). ".com", 'message' => Str::random(450)]);
      $response
      ->assertStatus(400)
       ->assertJson([
           'nameError' => 'Character limit of 50 exceeded',
        ]);
    }
    public function testValidEmail()
    {
      $response = $this->json('POST', '/api/inquiry', ['name' => Str::random(10),
       'phone' => '123456789', 'email' => Str::random(10), 'message' => Str::random(450)]);
      $response
      ->assertStatus(400)
       ->assertJson([
           'emailError' => 'Email must be a valid email',
        ]);
    }
    public function testSuccess()
    {
      $response = $this->json('POST', '/api/inquiry', ['name' => Str::random(10),
       'phone' => '123456789', 'email' => Str::random(5)."@".Str::random(10). ".com", 'message' => Str::random(450)]);
      $response
      ->assertStatus(200)
       ->assertJson([
           'success'=>'Data is successfully added',
        ]);
    }
}
