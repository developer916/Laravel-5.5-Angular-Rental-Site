<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\EmailRequest;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\Models\Email;

use App\Models\Language;
use File;

class EmailController extends AdminController {

    public function getEmailEvents () {
        $return = [];
        $files  = File::allFiles(base_path() . '/app/Events/');
        foreach ($files as $file) {
            if (stristr($file->getRelativePathname(), '.php') && $file->getRelativePathname() != 'Event.php') {
                $return[] = str_replace('.php', '', $file->getRelativePathname());
            }
        }

        return response()->json($return);
    }

    public function getEmails () {
        $emails = Email::all();
        foreach ($emails as $email) {

            if ($email->status == 0) {
                $email->status = '<span class="label label-sm label-danger">Draft</span>';
            } else {
                $email->status = '<span class="label label-sm label-success">Published</span>';
            }

            $email->language_id = '<img src="' . env('AWS_CLOUDFRONT_URL') . '/assets/flags/' . $email->language['icon'] . '" />';

            $email->actions = '
<!--			<a class="btn btn-xs info" ng-click="editEmail(' . $email->id . ')" href="javascript:;"><i class="fa fa-pencil"></i> Edit</a>-->
			<a class="btn btn-xs danger" ng-click="deleteEmail(' . $email->id . ')"  href="javascript:;"><i class="fa fa-trash-o"></i> Delete</a>';
        }

        return response()->json(['data' => $emails, 'recordsTotal' => count($emails), 'recordsFiltered' => 0, 'draw' => 0]);
    }

    public function postSaveEmail (EmailRequest $request) {
        $mailsPath            = base_path() . '/resources/views/emails/';
        $postData             = $request->all();
        $email                = new Email;
        $email->status        = $postData['status'];
        $email->email_subject = $postData['email_subject'];
        $email->event         = $postData['event'];
        $email->language_id   = $postData['language_id'];

        $language = Language::find($postData['language_id']);
        if ($language) {
            $emailFile = $postData['event'] . '_' . $language->lang_code . '.blade.php';
            if ($emailFile) {
                if ($email->save()) {
                    File::put($mailsPath . $emailFile, $postData['html']);
                }
            } else {
                return response()->json(['status' => 0, 'message' => trans('emails.language_not_found')]);
            }
        }

        return response()->json(['status' => 1, 'message' => $emailFile . ' ' . trans('emails.written')]);
    }

    public function getDeleteEmail ($id) {
        $email = Email::find($id);
        if ($email->delete()) {
            return response()->json(['reply' => 'success']);
        } else {
            return response()->json(['reply' => 'fail']);
        }
    }


}
