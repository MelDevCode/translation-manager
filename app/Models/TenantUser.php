<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;



class TenantUser extends Pivot
{
    protected $table = 'tenant_user';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['tenant_id', 'user_id'];
    public $timestamps = false;

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}