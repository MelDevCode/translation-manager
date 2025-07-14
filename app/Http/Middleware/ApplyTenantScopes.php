<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\TenantUser;

class ApplyTenantScopes
{
    
    public function handle(Request $request, Closure $next): Response
    {
        TenantUser::addGlobalScope(
            fn (Builder $query) => $query->where('tenant_id', Filament::getTenant()->id),
        );

        return $next($request);
    }
}
