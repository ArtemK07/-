<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $companiesLimit = 10;
        $userLimit = 30;
        $faker = Faker\Factory::create();

        
        for ($i = 1; $i<$companiesLimit; $i++){
            DB::table('companies')->insert([
                'id' => $i,
                'name' => $faker->company,
                'quota' => $faker->numberBetween(1000,2000)
            ]);
        }
        
        
        for ($i = 1; $i < $userLimit; $i++) {
            DB::table('user')->insert([
                    'id' => $i,
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'company_id' => $faker->numberBetween(1, ($companiesLimit-1))
                ]
            );
        }
        
        for($i =1; $i< 200; $i++){
            DB::table('transfer_logs')->insert([
                'id' => $i,
                'user_id' => rand(1,($userLimit-1)),
                'date' => $faker->date('Y-m-d'),
                'resource' => $faker->url,
                'transferred' => $faker->numberBetween(100,200)
            ]);
        }
    }
}
