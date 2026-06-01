<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'google_id',
        'password',
        'avatar'
    ];

    protected static $logAttributes = ['name', 'username'];

    protected static $igonoreChangedAttributes = ['updated_at'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logOnlyDirty = true;

    protected static $logName = 'user';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} user";
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole('Admin');
    }
}