<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
        ]);

        \App\Models\Count::factory(15)->create();


        // - devdays.png を storage にコピー ------------------------------
        $from = public_path('img/devdays.png');
        $to = storage_path('app/public/images/devdays.png');

        if(File::exists($from)) {
            File::copy($from, $to);
        }
    }
}
