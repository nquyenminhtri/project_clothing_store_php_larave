<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AuthenticateCustomer extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return route('customer.login');
    }
}