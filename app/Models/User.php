<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Tambahkan 'role' ke dalam Fillable
#[Fillable(['tenant_id', 'name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    
    // --- HELPER UNTUK CEK ROLE NANTINYA ---
    public function isSuperAdmin() { return $this->role === 'super_admin'; }
    public function isOwner() { return $this->role === 'owner'; }
    public function isManager() { return $this->role === 'manager'; }
    public function isWarehouse() { return $this->role === 'warehouse'; }
    public function isMarketing() { return $this->role === 'marketing'; }
}