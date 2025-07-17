<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'tenant_id',
        'glossary_id',
        'source_term',
        'target_term',
        'type',
        'part_of_speech',
        'domain',
        'context',
        'created_by',
    ];

    public function glossary()
    {
        return $this->belongsTo(Glossary::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
