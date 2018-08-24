<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $output;

    protected $tables = [
        'users',
        'mobile_operators',
        'world_cities'
    ];

    protected $seeders = [
        'MobileOperatorTableSeeder',
        'WorldCitiesTableSeeder',
        'WorldCountriesTableSeeder'
    ];

    public function run()
    {
        $this->output = new ConsoleOutput();
        $this->output->writeln('Resetting Ranking Database ...');

        $this->resetDatabase();

        $this->output->writeln('Unguarding models');
        Model::unguard();

        foreach($this->seeders as $seeder)
        {
            $this->call($seeder);
        }
    }

    private function resetDatabase()
    {
        $env = App::environment();
        $this->output->writeln("Truncating tables in $env environment");

        if (App::isLocal())
        {
            foreach ($this->tables as $table) {
                $this->output->writeln("Truncating $table");
                DB::statement('TRUNCATE TABLE ' . $table . ' CASCADE;');
            }
        }
        elseif (App::runningUnitTests())
        {
            Eloquent::unguard();
            foreach ($this->tables as $table) {
                $this->output->writeln("Truncating $table");
                DB::statement('TRUNCATE TABLE ' . $table . ' CASCADE;');
            }
        }
    }
}
