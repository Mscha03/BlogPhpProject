<?php

namespace App\Classes;

use App\Entities\UserEntity;

class Auth
{
    public static function loginUser($user): void
    {
        Session::set('user', $user->toArray());
    }

    public static function logoutUser(): void
    {
        Session::forget('user');
        redirect('index.php', ['action' => 'login']);
    }

    public static function getLoggedInUser(): UserEntity
    {
        return new UserEntity(Session::get('user'));
    }

    public static function isAuthenticated(): bool
    {
        return Session::has('user');
    }

    public static function checkAuthenticated(): void
    {
        if (!self::isAuthenticated()) {
            redirect('index.php', ['action' => 'login']);
        }
    }
}