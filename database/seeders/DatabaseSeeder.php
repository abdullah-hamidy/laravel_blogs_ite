<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::factory(10)->create();
/*         \App\Models\User::create([
           'name' => 'Hanifullah',
            'email' => 'hanifullah@gmail.com',
            'phone' => '+93779636360',
            'photo' => 'https://avatars.githubusercontent.com/u/43265047?v=4',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);
 */
        
    }
}
