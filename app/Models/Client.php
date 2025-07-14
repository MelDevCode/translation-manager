<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'notes',
        'tenant_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
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
