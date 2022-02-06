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

class MattsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
     /** @test */
    public function matts_conversations()
    {
        $user1 = User::factory()->create(['name' => 'kieran']);
        $user2 = User::factory()->create(['name' => 'ed']);
        $user3 = User::factory()->create(['name' => 'matt']);
        $user4 = User::factory()->create(['name' => 'dan']);
        $user5 = User::factory()->create(['name' => 'nickel']);

        $conversation1 = Conversation::factory()->create(['name' => 'personal', 'owner' => $user3->id]);
        $conversation2 = Conversation::factory()->create(['name' => 'school work','owner' => $user3->id]);
        $conversation3 = Conversation::factory()->create(['name' => 'coding','owner' => $user3->id]);

        $conversation1->users()->attach($user3->id , []);
        $message = Message::factory()->create(['user_id'=> $user3->id, 'conversation_id'=> $conversation1->id, 'message' => 'Do Maths']);
        $conversation1->messages()->save($message); 
        $message = Message::factory()->create(['user_id'=> $user3->id, 'conversation_id'=> $conversation1->id, 'message' => 'Revise Bio']);
        $conversation1->messages()->save($message); 
        $message = Message::factory()->create(['user_id'=> $user3->id, 'conversation_id'=> $conversation1->id, 'message' => 'Wake Up!!!']);
        $conversation1->messages()->save($message); 

        $conversation2->users()->attach($user1->id , []);
        $conversation2->users()->attach($user2->id , []);
        $conversation2->users()->attach($user3->id , []);
        $conversation2->users()->attach($user4->id , []);
        $conversation2->users()->attach($user5->id , []);

        $message = Message::factory()->create(['user_id'=> $user1->id, 'conversation_id'=> $conversation2->id, 'message' => 'Ive lost my planner']);
        $conversation2->messages()->save($message); 
        $message = Message::factory()->create(['user_id'=> $user2->id, 'conversation_id'=> $conversation2->id, 'message' => 'Oof']);
        $conversation2->messages()->save($message); 
        $message = Message::factory()->create(['user_id'=> $user4->id, 'conversation_id'=> $conversation2->id, 'message' => 'Where do you leave it?']);
        $conversation2->messages()->save($message); 
        $message = Message::factory()->create(['user_id'=> $user1->id, 'conversation_id'=> $conversation2->id, 'message' => 'I dont know']);
        $conversation2->messages()->save($message); 
        $message = Message::factory()->create(['user_id'=> $user5->id, 'conversation_id'=> $conversation2->id, 'message' => 'Here is a picture of my perfect planner']);
        $conversation2->messages()->save($message); 

        $conversation3->users()->attach($user2->id , []);
        $conversation3->users()->attach($user3->id , []);
        $conversation3->users()->attach($user5->id , []);

        $message = Message::factory()->create(['user_id'=> $user2->id, 'conversation_id'=> $conversation2->id, 'message' => 'How do i run my python script']);
        $conversation3->messages()->save($message); 
        $message = Message::factory()->create(['user_id'=> $user3->id, 'conversation_id'=> $conversation2->id, 'message' => 'Theres an app called thony']);
        $conversation3->messages()->save($message);
        $message = Message::factory()->create(['user_id'=> $user5->id, 'conversation_id'=> $conversation2->id, 'message' => 'Or you could use trinket']);
        $conversation3->messages()->save($message);  

        $this->assertEquals(1, $conversation1->users->count());
        $this->assertEquals(5, $conversation2->users->count());
        $this->assertEquals(3, $conversation3->users->count());

        // $users = $conversation1->users;
        // foreach($users as $user) {
        //     Log::debug($conversation1->id . " (" . $conversation1->name . ") | " . $user->id. " (" . $user->name . ")");
        // }
        // $users = $conversation2->users;
        // foreach($users as $user) {
        //     Log::debug($conversation2->id . " (" . $conversation2->name . ") | " . $user->id. " (" . $user->name . ")");
        // }
        // $users = $conversation3->users;
        // foreach($users as $user) {
        //     Log::debug($conversation3->id . " (" . $conversation3->name . ") | " . $user->id. " (" . $user->name . ")");
        // }

        $conversations = Conversation::all();
        foreach($conversations as $conversation) {
            Log::debug("\n");
            Log::debug(">>> " . $conversation->name);
            $messages = $conversation->messages;
            foreach($messages as $message) {
                Log::debug($message->user->name . ":" . $message->message);
            }
        }
    }
}