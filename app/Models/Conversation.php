<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversations';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id', 'updated_at', 'created_at'];

    public function users()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);

        return $this->belongsToMany(
            User::class,
            'conversation_user',
            'conversation_id',
            'user_id')
            ->withTimestamps()
            ->withPivot('id', 'created_at', 'updated_at', 'user_id', 'conversation_id')
            ->orderBy('user_id', 'asc');
    }
    
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }
}
