<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'avatar_url'
    ];

    public function conversations(){
        return $this->belongsToMany(Conversation::class,'participants')
                    ->latest('last_message_id')
                    ->withPivot([
                        'role','joined_at'
                    ]);
    }

    /**
     * Get all of the sentMessages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }


    /**
     * Get all of the receviedMessages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receviedMessages(): HasMany
    {
        return $this->belongsToMany(Message::class, 'recipients', 'id')->withPivot(['read_at','deleted_at']);
    }

    public function getAvatarUrlAttribute() {
        return "https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=".$this->name;
    }


}
