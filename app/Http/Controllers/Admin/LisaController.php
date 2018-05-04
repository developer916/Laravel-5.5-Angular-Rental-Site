<?php namespace App\Http\Controllers\Admin;

use Auth;

use App\Http\Controllers\AdminController;
use App\Models\Lisa;
use App\Models\Tenant;
use App\Models\Language;

Use Illuminate\Support\Facades\DB;

use App\Http\Requests\Admin\LisaRequest;

class LisaController extends AdminController {

    /**
     * @param LisaRequest $request
     *
     * Display LISA help based on the page uri
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function postIndex (LisaRequest $request) {

        $languageId = Language::where('lang_code', \App::getLocale())->first()['id'];

        $data = $request->all();
        $uri  = trim(str_replace(['#', '/'], '', $data['url']['hash']));
        $help = DB::table('help')->where('uri', $uri)->where('language_id', $languageId)->get(['title', 'content', 'video']);
        return response()->json($help);

    }

}
