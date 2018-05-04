<?php
    namespace App\Http\Controllers\Admin;

    use App\Events\UserPasswordWasReset;
    use App\Http\Controllers\AdminController;
    use App\Http\Requests\Admin\UserPasswordChangeRequest;
    use App\Http\Requests\Admin\UserPasswordResetRequest;
    use App\User;
    use Auth;
    use Log;

    class UserPasswordController extends AdminController {


        public function postReset (UserPasswordResetRequest $request) {
            if (Auth::getUser()) {
                $user = User::where('id', Auth::getUser()->id)->first();
                \Event::fire(new UserPasswordWasReset($user, 'reset-user-password-email'));
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 0]);
            }
        }
    }
