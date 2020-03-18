<?php

use Illuminate\Database\Seeder;
use App\Province;
use App\City;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daftarProvinsi = RajaOngkir::provinsi()->all();
        foreach ($daftarProvinsi as $provinceRow) {
            Province::create([
                'id' => $provinceRow['province_id'],
                'title' => $provinceRow['province']
            ]);
            $daftarKota = RajaOngkir::kota()->dariProvinsi($provinceRow['province_id'])->get();
            foreach ($daftarKota as $cityRow) {
                City::create([
                    'id' => $cityRow['city_id'],
                    'province_id' => $provinceRow['province_id'],
                    'title' => $cityRow['city_name']
                ]);
            }
        }
    }
}
