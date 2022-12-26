<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\User;
  
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                "name" => "Admin",
                "email" => "admin@gmail.com",
                "phone" => "9988126816",
                "dob" => "29-04-2022",
                "type" => "admin",
                "password" => bcrypt("123456")
            ]);
    }
}