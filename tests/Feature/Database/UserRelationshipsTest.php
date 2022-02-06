<?php
namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use Auth;
use Log;

use App\Models\User;

use App\Models\Conversation;

class UserRelationshipsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function user_conversation_relationships()
    {
        $user1 = User::factory()->create();
        $this->assertDatabaseHas('users',['id'=> $user1->id ]);

        $user2 = User::factory()->create();
        $this->assertDatabaseHas('users',['id'=> $user2->id ]);

        $conversation1 = Conversation::factory()->create(['owner' => $user1->id]);
        $this->assertDatabaseHas('conversations',['id'=> $conversation1->id ]);

        $conversation2 = Conversation::factory()->create(['owner' => $user1->id]);
        $this->assertDatabaseHas('conversations',['id'=> $conversation2->id ]);

        $user1->conversations()->attach($conversation1->id , []);
        $this->assertDatabaseHas('conversation_user',['conversation_id'=> $conversation1->id,'user_id'=> $user1->id ]);

        $user1->conversations()->attach($conversation2->id , []);
        $this->assertDatabaseHas('conversation_user',['conversation_id'=> $conversation2->id,'user_id'=> $user1->id ]);

        $user2->conversations()->attach($conversation1->id , []);
        $this->assertDatabaseHas('conversation_user',['conversation_id'=> $conversation1->id,'user_id'=> $user2->id ]);

        $user2->conversations()->attach($conversation2->id , []);
        $this->assertDatabaseHas('conversation_user',['conversation_id'=> $conversation2->id,'user_id'=> $user2->id ]);

        // user1 hasMany Conversations
        $this->assertTrue($user1->conversations->contains($conversation1));
        $this->assertTrue($user1->conversations->contains($conversation2));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user1->conversations); 
        $this->assertEquals(2, $user1->conversations->count()); 

        // user2 hasMany Conversations
        $this->assertTrue($user2->conversations->contains($conversation1));
        $this->assertTrue($user2->conversations->contains($conversation2));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user2->conversations); 
        $this->assertEquals(2, $user2->conversations->count()); 

        // conversation1 hasMany Users
        $this->assertTrue($conversation1->users->contains($user1));
        $this->assertTrue($conversation1->users->contains($user2));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $conversation1->users);
        $this->assertEquals(2, $conversation1->users->count());

        // conversation2 hasMany Users
        $this->assertTrue($conversation2->users->contains($user1));
        $this->assertTrue($conversation2->users->contains($user2));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $conversation2->users);
        $this->assertEquals(2, $conversation2->users->count());

        log(count($user1->conversations));
        $user1sConversations = $user1->conversations;
        foreach($user1sConversations as $conversation) {
            Log::debug($conversation->name);
        }
    }    
}