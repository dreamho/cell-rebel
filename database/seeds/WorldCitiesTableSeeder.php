<?php

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Ranking\Models\WorldCity;

class WorldCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::load($this->getFile(), function($reader) {
            $reader->each(function($row){
                $item = $row->toArray();
                dump('Adding ' . $item[3] . '...' );
                factory(WorldCity::class)->create([
                    'id'        => $item[0],
                    'code'      => $item[1],
                    'country'   => $item[2],
                    'name'      => $item[3],
                    'latitude'  => $item[4],
                    'longitude' => $item[5],
                    'altitude'  => $item[6]
                ]);
            });
        });
    }

    public function getFile()
    {
        return storage_path('csv').'/World_Cities_Location_table.csv';
    }
}
