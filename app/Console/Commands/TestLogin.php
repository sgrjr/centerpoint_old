<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing 10 random logins';

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
        $users = \App\Models\User::all();
        $failed = 0;
        $passed = 0;

        foreach($users AS $user){
            $attempt = \Auth::attempt(["EMAIL"=> $user->EMAIL, "password"=>$user->MPASS]);
            var_dump($attempt);
            if($user !== null && \Auth::user() !== null){
                $passed++;
            }else{
                $failed++;
            }
        }

        var_dump('passed: ' . $passed);
        var_dump('failed: ' . $failed);

    }
}
