<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use HasRoles;
    use HasUuids;
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'username',
        'email',
        'mobile',
        'user_type',
        'profile_photo',
        'is_active',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 'yes');
    }
    public function scopeStaff($query)
    {
        return $query->where('user_type', 'staff');
    }
    public function scopeAgents($query)
    {
        return $query->where('user_type', 'agent');
    }
    public function scopeClients($query)
    {
        return $query->where('user_type', 'client');
    }
    public function isSuperAdmin(): bool
    {
        return $this->user_type === 'superadmin';
    }
    public function isStaff(): bool
    {
        return $this->user_type === 'staff';
    }
    public function isAgent(): bool
    {
        return $this->user_type === 'agent';
    }
    public function isClient(): bool
    {
        return $this->user_type === 'client';
    }
}