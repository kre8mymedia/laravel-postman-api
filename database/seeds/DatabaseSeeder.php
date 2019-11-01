<?php

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
        // $this->call(UsersTableSeeder::class);

        $x = new App\User;
        $x->name = 'Harry';
        $x->email = 'Harry@test.com';
        $x->password = 'changeme123';
        $x->save();

        $x = new App\User;
        $x->name = 'Charles';
        $x->email = 'Charles@test.com';
        $x->password = 'changeme123';
        $x->save();

        $x = new App\User;
        $x->name = 'Marley';
        $x->email = 'Marley@test.com';
        $x->password = 'changeme123';
        $x->save();

        $x = new App\Ticket;
        $x->title = 'I have this problem';
        $x->body = 'This is the logng form description of problem Im having';
        $x->save();

        $x = new App\Ticket;
        $x->title = 'I have this problem from NEIGHBOR';
        $x->body = 'This is the logng form description of problem Im having ME TOO help';
        $x->save();

        $x = new App\Role;
        $x->user_id = 2;
        $x->name = 'Manager';
        $x->save();

        $x = new App\Role;
        $x->user_id = 1;
        $x->name = 'Owner';
        $x->save();

        $x = new App\Role;
        $x->user_id = 3;
        $x->name = 'Tenant';
        $x->save();
        
    }
}
