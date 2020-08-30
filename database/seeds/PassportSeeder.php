<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //populate records in oauth_client table
        $data = [
            [
                'id' => 1,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'SFwXJOwyLyOerMk9aINAUWK5PilaJEu7Fgd8UwyF',
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 1,
                'revoked' => 0,
            ]
        ];

        DB::table('oauth_clients')->truncate();
        DB::table('oauth_clients')->insert($data);
    }
}
