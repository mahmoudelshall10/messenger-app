<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','label','last_message_id','type'
    ];

    public function participants() {
      return $this->belongsToMany(User::class, 'participants')->withPivot(['joined_at','role']);
    }

    public function recipients()
    {
        return $this->hasManyThrough(
            Recipient::class,
            Message::class,
            'conversation_id',
            'message_id',
            'id',
            'id'
        );
    }

    public function messages(){
        return $this->hasMany(Message::class, 'conversation_id','id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }

     /**
     * Get the lastMessage that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id', 'id')->withDefault();
    }
}
