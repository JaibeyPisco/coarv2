<?php

namespace Database\Seeders;

use App\Models\Static_ubigeo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StaticUbigeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            $data = File::get(base_path() . '\database\seeders\static_ubigeo.json');

            $data = json_decode($data, true);

            foreach ($data as $ubigeo) {
               Static_ubigeo::updateOrCreate(
                   ['id_ubigeo' => $ubigeo['id']],
                    [
                        'provincia' => $ubigeo['provincia'],
                        'departamento' => $ubigeo['departamento'],
                        'distrito' => $ubigeo['distrito']
                    ]
               );
            }

    }
}
