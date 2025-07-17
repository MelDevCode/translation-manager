<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'name',
        'role',
        'due_date',
        'status',
        'project_id',
        'user_id',
        'file_id',
        'language_pair',
        'type',
        'word_count',
        'rate_per_word',
        'instructions',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
    
    public function glossary()
    {
        return $this->belongsTo(Glossary::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
