<?php

use App\Models\Salutation;
use Illuminate\Database\Seeder;

class SalutationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salutation = new Salutation;
        $salutation
            ->setTranslation('prefix', 'en', 'Dear')
            ->setTranslation('prefix', 'de', 'Sehr geehrter');
        $salutation
            ->setTranslation('name', 'en', 'Mr.')
            ->setTranslation('name', 'de', 'Herr');
        $salutation
            ->setTranslation('gender', 'en', 'male')
            ->setTranslation('gender', 'de', 'männlich');
        $salutation->gender_id = 0;
        $salutation->save();
        //
        $salutation = new Salutation;
        $salutation
            ->setTranslation('prefix', 'en', 'Dear')
            ->setTranslation('prefix', 'de', 'Sehr geehrte');
        $salutation
            ->setTranslation('name', 'en', 'Mrs.')
            ->setTranslation('name', 'de', 'Frau');
        $salutation
            ->setTranslation('gender', 'en', 'female')
            ->setTranslation('gender', 'de', 'weiblich');
        $salutation->gender_id = 1;
        $salutation->save();
        $salutation
            ->setTranslation('prefix', 'en', 'Dear')
            ->setTranslation('prefix', 'de', 'Sehr geehrte/r');
        $salutation
            ->setTranslation('name', 'en', 'Sir or Madam')
            ->setTranslation('name', 'de', 'Damen und Herren');
        $salutation
            ->setTranslation('gender', 'en', 'indeterminate')
            ->setTranslation('gender', 'de', 'unbestimmt');
        $salutation->gender_id = 2;
        $salutation->save();
    }
}
