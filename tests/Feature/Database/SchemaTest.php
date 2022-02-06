<?php
namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SchemaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test  */
    public function conversations_has_expected_columns() { 
        $this->assertTrue(
            Schema::hasColumns('conversations', [
            'id',
            'created_at',
            'updated_at',
            'name',
            'owner',
        ]), 1);
    }
     
        
    /** @test  */
    public function conversation_user_has_expected_columns() { 
        $this->assertTrue(
            Schema::hasColumns('conversation_user', [
            'id',
            'created_at',
            'updated_at',
            'conversation_id',
            'user_id',
        ]), 1);
    }

    /** @test  */
    public function messages_has_expected_columns() { 
        $this->assertTrue(
            Schema::hasColumns('messages', [
            'id',
            'created_at',
            'updated_at',
            'message',
            'user_id',
            'conversation_id',
        ]), 1);
    }

     /** @test  */
     public function users_has_expected_columns() { 
        $this->assertTrue(
            Schema::hasColumns('users', [
            'id',
            'created_at',
            'updated_at',
            'name',
            'email',
            'email_verified_at',
            'password',
            'remember_token',
        ]), 1);
    }
}