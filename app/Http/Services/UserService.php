<?php

namespace App\Http\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserService
{

    public function getRelativePath(){
        return '/uploads/' . md5(Auth::user()->id . Config::get('app.key'));
    }
}