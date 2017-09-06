<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        factory(App\User::class, 10)->create()->each(function ($u) {
            // link between 1 to 5 messages to each user
            $count = rand(1,5);
            for ($i=1; $i <= $count; $i++) { 
                $u->messages()->save(factory(App\Message::class)->make());
            }
        });
    }
}
