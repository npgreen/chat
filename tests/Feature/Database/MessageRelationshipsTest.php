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
use App\Models\Message;

class MessageRelationshipsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function message_relationships()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users',['id'=> $user->id ]);

        $conversation = Conversation::factory()->create(['owner' => $user->id]);
        $this->assertDatabaseHas('conversations',['id'=> $conversation->id ]);

        $user->conversations()->attach($conversation->id , []);

        $message1 = Message::factory()->create(['user_id'=> $user->id, 'conversation_id'=> $conversation->id, 'message' => 'poo poo']);
        $this->assertDatabaseHas('messages',['user_id'=> $user->id, 'conversation_id'=> $conversation->id, 'id'=> $message1->id ]);
        $conversation->messages()->save($message1); 

        $message2 = Message::factory()->create(['user_id'=> $user->id, 'conversation_id'=> $conversation->id, 'message' => 'wee wee']);
        $conversation->messages()->save($message1); 

        $this->assertTrue($user->conversations->contains($conversation));
        $this->assertEquals(1, $user->conversations->count()); 

        $this->assertTrue($conversation->users->contains($user));
        $this->assertEquals(1, $conversation->users->count());

        Log::debug("Users messages...");
        log(count($user->messages));
        $messages = $user->messages;
        foreach($messages as $message) {
            Log::debug($message->message);
        }

        Log::debug("\nConversations messages...");
        log(count($conversation->messages));
        $messages = $conversation->messages;
        foreach($messages as $message) {
            Log::debug($message->message);
        }
    }    
}