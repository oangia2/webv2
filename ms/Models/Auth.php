<?php
namespace MS\Models;

use oangia\MongoDB\DB;

class Auth {
    public static function findByEmail($email, $host) {
        $user = DB::find('microservices', 'users', ['email' => $email, 'host' => $host]);
        if (! $user) return null;
        return new User($user);
    }

    public static function currentUser() {
        if (! __cookie('user')) return false;
        $user = DB::find('microservices', 'users', ['_id' => new \MongoDB\BSON\ObjectId(__cookie('user')), 'host' => host_name()]);
        if (! $user) return false;
        return new User($user);
    }

    public static function register($data) {
        $user = DB::insert('microservices', 'users', $data);
        return $user;
    }

    public static function middleware($type = 'admin') {
        $user = Auth::currentUser();
        if (! $user) {
            Auth::redirectLogin();
        }
        if (! isset($user->role) || $user->role != $type) {
            Auth::redirectLogin();
        }
    }

    public static function redirectLogin() {
        header('Location: /myadmin/login');
        die();
    }
}