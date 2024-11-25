<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as AuthLogin;

class Login extends AuthLogin
{
    public function getTitle(): string
    {
        return 'Sign in';
    }

    public function getHeading(): string
    {
        return 'Welcome Back';
    }

    public function getSubHeading(): string
    {
        return 'Sign in to your account';
    }
}
