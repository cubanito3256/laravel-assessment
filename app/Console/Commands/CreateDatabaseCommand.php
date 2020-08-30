<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new database based on the name as parameter or configured in .env file';

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
        try{
            $dbName = $this->argument('name');

            $this->info("Creating database `$dbName`");
            DB::statement("CREATE DATABASE IF NOT EXISTS `:dbName`;", array('dbName' => $dbName));
            $this->info("Done");
        }
        catch (\Exception $e){
            $this->error($e->getMessage());
        }
    }

    // private function setEnv($key, $value)
    // {
    //     file_put_contents(app()->environmentFilePath(), str_replace(
    //         $key . '=' . env($value),
    //         $key . '=' . $value,
    //         file_get_contents(app()->environmentFilePath())
    //     ));
    // }
}
