<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EnableUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:enable {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks user as enabled';

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
        else if ($user->enabled){
            $this->error('User is already enabled');
        }
        else {
            $user->enabled = true;
            $user->save();
            $this->info('User was enabled');
        }

        return 0;
    }
}
