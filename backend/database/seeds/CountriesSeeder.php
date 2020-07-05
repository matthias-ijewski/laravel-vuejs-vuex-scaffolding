<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        include('countries.php');
        foreach ($countries as $c) {
            $country = new Country();
            $country->setTranslation('name', 'en', $c[4])
                ->setTranslation('name', 'de', $c[3]);
            $country->iso = $c[1];
            $country->id = $c[0];
            $country->iso3 = $c[5];
            $country->numcode = $c[6];
            $country->phonecode = $c[7];
            $country->save();
        }
    }
}
