<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Glossary extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'source_language',
        'target_language',
    ];
    
    public function terms(): HasMany
    {
        return $this->hasMany(GlossaryTerm::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'glossary_project');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
