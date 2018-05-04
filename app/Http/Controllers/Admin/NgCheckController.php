<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Profile;
use Auth;

class NgCheckController extends AdminController {

    public function postUser () {
        if (Auth::user()) {
            $check = [
                'id'        => Auth::user()->id,
                'name'      => Auth::user()->name,
                'role_id'   => Auth::user()->role_id,
                'role'      => Auth::user()->role,
                'profile'   => Profile::with('currency')->where('user_id', Auth::user()->id)->first(),
                'has_login' => Auth::user()->has_login
            ];
            if (!$check['profile']) {
                $profile          = new Profile();
                $profile->user_id = Auth::user()->id;
                $profile->save();
                $check['profile'] = Profile::with('currency')->where('user_id', Auth::user()->id)->first();
            }

            return response()->json($check);
        }
    }

    public function getSetLocale ($locale) {
        \App::setLocale($locale);
    }

    /*
    * fixing a bug - dont ask
    */
    public function getUser () {
        return redirect('dashboard');
    }
}
