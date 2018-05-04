<?php
    use Illuminate\Database\Seeder;
    use App\Models\Language;

    class LanguagesTableSeeder extends Seeder {

        public function run () {
            DB::table('languages')->delete();

            $language            = new Language();
            $language->name      = 'English';
            $language->lang_code = 'en';
            $language->icon      = "gb.png";
            $language->save();

            $language            = new Language();
            $language->name      = 'Nederlands';
            $language->lang_code = 'nl';
            $language->icon      = "nl.png";
            $language->save();
        }

    }
