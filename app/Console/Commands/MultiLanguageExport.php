<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Translations;
use App\Models\Language;
use File;

class MultiLanguageExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:multiLanguageExport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Multi Language Export';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $languages = Language::all();
       if(count($languages) >0 ){
           foreach ($languages as $language) {
               $i18n   = Translations::where('language_id', $language->id)->get(['label', 'label_key']);
               $return = [];
               foreach ($i18n as $key => $value) {
                   if ($value->label) {
                       $return[ $value->label_key ] = $value->label;
                   }
               }

               $translations = json_encode($return);

               $languageData = Language::where('id', $language->id)->first(['lang_code']);

               $ngLanguageFile      = public_path('/languages/' . $languageData->lang_code . '.json');

               if (is_file($ngLanguageFile)) {
                   unlink($ngLanguageFile);
               }

               $writeToNG = public_path('/languages/' . $languageData->lang_code . '.json');
               File::put($writeToNG, $translations);
           }
       }
        $this->info('Multi Language Export Successfully');
    }
}
