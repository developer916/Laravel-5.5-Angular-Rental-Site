<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Input;
use App\Models\Language;
use App\Models\Translations;
use Log;
use Auth;
use File;
use App\Http\Requests\Admin\TranslateRequest;

class LanguageController extends AdminController {

    public function getTranslations () {
        $translations = Translations::whereNotNull('language_id')->get(['id', 'label_key', 'label', 'language_id']);

        $return = [];
        foreach ($translations as $key => $value) {
            $return[ $value->language_id ][] = [
                'key'   => $value->label_key,
                'value' => $value->label,
                'id'    => $value->id
            ];
        }

        return response()->json($return);
    }

    public function getAvailableLanguages () {
        return response()->json(Language::all(['name', 'lang_code', 'icon']));
    }

    public function postNewItem (TranslateRequest $request) {
        $i18n              = new Translations;
        $i18n->label       = $request->all()['label'];
        $i18n->label_key   = $request->all()['label_key'];
        $i18n->user_id     = Auth::user()->id;
        $i18n->language_id = $request->all()['language_id'];
        if ($i18n->save()) {
            return response()->json(['status' => 1]);
        } else {
            Log::error('[@] Unable to save the i18n model', $i18n);

            return response()->json(['status' => 0]);
        }
    }

    public function postUpdateItem (TranslateRequest $request, $id) {

        $i18n            = Translations::find($request->all()['id']);
        $i18n->label     = $request->all()['value'];
        $i18n->label_key = $request->all()['key'];
        $i18n->user_id   = Auth::user()->id;
        if ($i18n->save()) {
            return response()->json(['status' => 1]);
        } else {
            Log::error('[@] Unable to update the i18n model:', $i18n);

            return response()->json(['status' => 0]);
        }
    }

    /**
     * @param TranslateRequest $request
     *
     * Write all translations to the languages file for both laravel and angular
     * make sure to remove the files first
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function postPublish (TranslateRequest $request) {
        $i18n   = Translations::where('language_id', $request->all()['language_id'])->get(['label', 'label_key']);
        $return = [];

        // write angular strings
        foreach ($i18n as $key => $value) {
            if ($value->label) {
                $return[ $value->label_key ] = $value->label;
            }
        }
        // write laravel strings

        $laravelTranslateString = "<?php\n\n return [\n";

        foreach ($i18n as $key => $value) {
            if ($value->label) {
                $laravelTranslateString .= "'$value->label_key' => '$value->label',\n";
            }
        }
        $laravelTranslateString .= "\n];\n";

        $translations = json_encode($return);

        $languageData = Language::where('id', $request->all()['language_id'])->first(['lang_code']);

        $ngLanguageFile      = public_path('/languages/' . $languageData->lang_code . '.json');
        $laravelLanguageFile = base_path('resources/lang/' . $languageData->lang_code . '/admin/admin.php');

        // remove ng file
        if (is_file($ngLanguageFile)) {
            unlink($ngLanguageFile);
        }
        // remove laravel file
        if (is_file($laravelLanguageFile)) {
            unlink($laravelLanguageFile);
        }

        $writeToNG = public_path('/languages/' . $languageData->lang_code . '.json');
        $writeToLv = $laravelLanguageFile;

        $ngWritten = File::put($writeToNG, $translations);
        $lvWritten = File::put($writeToLv, $laravelTranslateString);
        if ($lvWritten === FALSE || $ngWritten === FALSE) {
            return response()->json(['status' => 0, 'ng' => $ngWritten, 'lv' => $lvWritten]);
        } else {
            return response()->json(['status' => 1]);
        }
    }


    public function getTranslationLanguages () {
        return response()->json(Language::all(['id', 'lang_code', 'name']));
    }

    /**
     * Crawl all views and find matching regex for angular translation - {{'string to be translated' | translate}}
     * write only new strings to DB
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function postIndexFiles () {

        $viewsPath = public_path('views/');
        $views     = File::allFiles($viewsPath);

        $languages = Language::where('status', 1)->get(['id']);

        $strings = [];
        foreach ($views as $view) {

            $viewFile = $view->getPathName();

            $viewContent = file_get_contents($viewFile);
            $matches     = [];

            preg_match_all("/{{\'\b(.*)\' | translate}}/", $viewContent, $matches);

            foreach ($matches as $match) {
                if (is_array($match)) {
                    foreach ($match as $innerMatch) {
                        if (!stristr($innerMatch, 'translate')) {
                            if (strlen($innerMatch) > 0) {
                                array_push($strings, trim(str_replace(['{{', '\'',], '', $innerMatch)));
                            }
                        }
                    }
                }
            }
        }

        $saves = [];
        foreach ($languages as $language) {

            foreach ($strings as $string) {
                $searchString = Translations::where('label_key', trim($string))->where('language_id', $language->id)->first();
                if (!$searchString) {
                    $newString              = new Translations();
                    $newString->label_key   = trim($string);
                    $newString->user_id     = Auth::user()->id;
                    $newString->language_id = $language->id;
                    if ($newString->save()) {
                        $saves[] = 1;
                        unset($newString);
                    } else {
                        Log::error('Failed saving translation string', $newString);
                    }
                }
            }
        }

        if (count($saves) == 0) {
            $msg = trans('language.no_new');
        } else {
            $msg = count($saves) . trans('language.found_new');
        }

        return response()->json(['status' => 1, 'msg' => $msg]);
    }

}
