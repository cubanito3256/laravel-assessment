<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DisableUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:disable {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks user as disabled';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$user = \App\User::where('email', $email = $this->argument('email'))->first()){
            $this->error("User `$email` does not exists");
        }
        else if (!$user->enabled){
            $this->error('User is already disabled');
        }
        else {
            // marks the user as disabled in the database
            $user->enabled = false;
            $user->save();

            // revokes all access_token issued to that user
            foreach($user->tokens as $token) {
                $token->revoke();   
            }

            $this->info('User was disabled and all access_tokens were revoked');
        }

        return 0;
    }
}
