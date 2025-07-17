<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'client_id',
        'created_by',
        'name',
        'source_language',
        'target_language',
        'status',
        'deadline',
        'instructions',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $query) {
            if (Filament::getTenant()) {
                $query->whereBelongsTo(Filament::getTenant());
            }
        });
    }
}
