<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

use App\Mail\DeleteAccount;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Models\Profile;
use App\Models\Activity;

use App\Http\Requests\Admin\AccountRequest;
use Mail;

class SettingsController extends AdminController {

    const ENCRYPT_PASSWORD = 'rt@omato@XO9O9';
    const ENCRYPT_SALT     = '!kQm*fF3pXe1Kbm%9';


    public function postSavePersonalInfo (AccountRequest $request) {
        $data = $request->all();
        $user = User::find($data['user']['id']);

        $user->name  = $data['user']['name'];
        $user->email = $data['user']['email'];
        $user->save();

        if ($user->profile) {
            $profile = Profile::where('user_id', Auth::user()->id)->first();
        } else {
            $profile = new Profile();
        }

        $profile->user_id = Auth::user()->id;
        $profile->phone   = $data['profile']['phone'];
        $profile->address = $data['profile']['address'];
        $profile->website = $data['profile']['website'];
        $profile->bio     = $data['profile']['bio'];
        $profile->save();

        return response()->json(['status' => 1]);
    }

    public function postSaveCurrency (AccountRequest $request) {
        $data = $request->all();
        $user = User::find(Auth::user()->id);

        if ($user->profile) {
            $profile = Profile::where('user_id', Auth::user()->id)->first();
        } else {
            $profile          = new Profile();
            $profile->user_id = Auth::user()->id;
        }
        //
        if (!isset($data['profile']['currency_id']) || !$data['profile']['currency_id']) {
            $data['profile']['currency_id'] = 1;
        }
        //
        $profile->currency_id = $data['profile']['currency_id'];
        $profile->vat         = (isset($data['profile']['vat'])) ? $data['profile']['vat'] : NULL;
        $profile->iban        = (isset($data['profile']['iban'])) ? self::encrypt($data['profile']['iban']) : NULL;
        $profile->swift       = (isset($data['profile']['swift'])) ? self::encrypt($data['profile']['swift']) : NULL;
        $profile->phone       =  (isset($data['profile']['phone'])) ? self::encrypt($data['profile']['phone']) : '';
        if ($profile->save()) {
            return response()->json(['status' => 1]);
        }
    }

    public function postSavePrivacy (AccountRequest $request) {
        $data = $request->all();
        $user = User::find(Auth::user()->id);

        if ($user->profile) {
            $profile = Profile::where('user_id', Auth::user()->id)->first();
        } else {
            $profile = new Profile();
        }

        if (isset($data['profile']['privacy']) && $data['profile']['privacy'] == 'private') {
            $profile->visibility = 2;
        } else {
            $profile->visibility = 1;
        }

        $profile->notifications = json_encode($data['profile']['notifications']);
        $profile->user_id       = Auth::user()->id;

        if ($profile->save()) {
            return response()->json(['status' => 1]);
        }
    }


    public function postSaveAvatar (AccountRequest $request) {
        $avatar = $request->all()['avatar'];
        $user   = User::find(Auth::user()->id);
        if ($user->profile) {
            $profile = Profile::where('user_id', Auth::user()->id)->first();
        } else {
            $profile = new Profile();
        }

        if (isset($avatar['profile']['remote_avatar_url'])) {
            $relativePath     = '/uploads/avatars/';
            $directory        = public_path() . $relativePath;
            if(!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            $avatarString     = file_get_contents($avatar['profile']['remote_avatar_url']);
            $avatarName       = time() . '.png';
            $avatarWrite      = file_put_contents($directory . '/' . $avatarName, $avatarString);
            $profile->avatar  = $relativePath . $avatarName;
            $profile->user_id = Auth::user()->id;
            if ($profile->save()) {
                return response()->json(['status' => 1]);
            }
        } else {

            $profile->avatar  = $avatar;
            $profile->user_id = Auth::user()->id;
            if ($profile->save()) {
                return response()->json(['status' => 1]);
            }
        }
    }

    public function postUploadAvatar (AccountRequest $request) {
        $profile = Profile::where('user_id', Auth::user()->id)->first();

        if (!$profile) {
            $profile          = new Profile();
            $profile->user_id = Auth::user()->id;
        }

        $filename = $request->file('file')->getClientOriginalName();
        $fileSize = $request->file('file')->getSize();
        $relativePath = '/uploads/avatars';
        $directory    = public_path() . $relativePath;
        if(!file_exists(public_path() . $relativePath)) {
                mkdir(public_path() . $relativePath, 0777, true);
        }
        $uploadStatus = $request->file('file')->move($directory, $filename);

        if ($uploadStatus) {
            $profile->avatar = $relativePath . '/' . $filename;
            if ($profile->save()) {
                $file = [
                    'file' => $profile->avatar,
                    'id' => $profile->id,
                    'file_size' => $fileSize,
                ];
                //                return response()->json($profile->avatar, 200);
                return response()->json($file);
            }
        } else {
            return response()->json([], 400);
        }
    }

    public  function postDeleteAccount(AccountRequest $request){
        $user = Auth::user();
        $confirmLink = route('deleteAccountConfirm', [$user->id ]);
        Mail::to($user->email)->send(new DeleteAccount($user,$confirmLink));
        Auth::logout();
        return response()->json(['status' =>0]);
    }
    public function postPasswordCheck(AccountRequest $request){
        $data = $request->all();
        $user = Auth::user();
        if(\Hash::check($data['account']['password'], $user->password)) {
            $result = 'success';
        }else {
            $result = 'failed';
        }
        return response()->json($result);
    }

    public function postSavePassword (AccountRequest $request) {
        $data = $request->all()['password'];

        $user = User::find(Auth::user()->id);

        $currentStoredPassword = $user->password;
        $currentPostPassword   = $data['current_password'];

        if (\Hash::check($currentPostPassword, $currentStoredPassword)) {
            if ($data['new_password'] == $data['confirm_new_password']) {
                $user->password = bcrypt($data['confirm_new_password']);
                $user->save();

                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 0, 'error' => trans('settings.no_match')]);
            }
        } else {
            return response()->json(['status' => 0, 'error' => trans('settings.current_wrong')]);
        }
    }

    public function getSettings () {
        $user = User::with('profile')->find(Auth::user()->id);
        if ($user->profile) {
            $user->profile->notifications = json_decode($user->profile->notifications);

            if (isset($user->profile->iban)) {
                $user->profile->iban = self::decrypt($user->profile->iban);
            }
            if (isset($user->profile->swift)) {
                $user->profile->swift = self::decrypt($user->profile->swift);
            }
            if(isset($user->profile->avatar)){
                if (strpos($user->profile->avatar, '/uploads/avatars') !== false) {
                    $files = [
                        'file' => $user->profile->avatar,
                        'id' => $user->profile->id,
                        'file_size' => filesize(public_path() .$user->profile->avatar),
                    ];
                }else {
                    $files = [];
                }
            }
        }
        $defaultAvatars = [
            'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar1.png',
            'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar2.png',
            'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar3.png',
            'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar4.png',
            'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar5.png',
            'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar6.png',
            'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar7.png',
            'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar8.png',
            'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar9.png'
        ];

        return response()->json(['user' => $user, 'profile' => $user->profile, 'avatars' => $defaultAvatars, 'files' => $files]);
    }

    public function getRemoveFileUpload(){
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        $profile->avatar = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar1.png';
        $profile->save();
        $formData = $this->getSettings();
        return response()->json($formData);
    }

    public function postChange (UserPasswordChangeRequest $request) {
        $user = User::where('id', Auth::getUser()->id)->first();
        if (password_verify($request->oldpassword, $user->password)) {
            $user->password = bcrypt($request->newpassword);
            $user->save();
        } else {
            Log::error('[@] Unable to update password for user', ['id' => $user->id]);

            return response()->json(['status' => 0]);
        }
    }


    public static function encrypt ($decrypted) {
        // Build a 256-bit $key which is a SHA256 hash of $salt and $password.
        $key = hash('SHA256', self::ENCRYPT_SALT . self::ENCRYPT_PASSWORD, TRUE);
        // Build $iv and $iv_base64.  We use a block size of 128 bits (AES compliant) and CBC mode.  (Note: ECB mode is inadequate as IV is not used.)
        srand();
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
        if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) {
            return FALSE;
        }
        // Encrypt $decrypted and an MD5 of $decrypted using $key.  MD5 is fine to use here because it's just to verify successful decryption.
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));

        // We're done!
        return $iv_base64 . $encrypted;
    }

    public static function decrypt ($encrypted) {
        if (mb_strlen($encrypted) < 30) {
            return FALSE;
        }
        // Build a 256-bit $key which is a SHA256 hash of $salt and $password.
        $key = hash('SHA256', self::ENCRYPT_SALT . self::ENCRYPT_PASSWORD, TRUE);
        // Retrieve $iv which is the first 22 characters plus ==, base64_decoded.
        $iv = base64_decode(substr($encrypted, 0, 22) . '==');
        // Remove $iv from $encrypted.
        $encrypted = substr($encrypted, 22);
        // Decrypt the data.  rtrim won't corrupt the data because the last 32 characters are the md5 hash; thus any \0 character has to be padding.
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
        // Retrieve $hash which is the last 32 characters of $decrypted.
        $hash = substr($decrypted, -32);
        // Remove the last 32 characters from $decrypted.
        $decrypted = substr($decrypted, 0, -32);
        // Integrity check.  If this fails, either the data is corrupted, or the password/salt was incorrect.
        if (md5($decrypted) != $hash) {
            return FALSE;
        }

        // Yay!
        return $decrypted;
    }


}
