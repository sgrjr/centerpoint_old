<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Request;

class GraphqlLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graphql:login {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command line way of setting and returning getting authorization token';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = \App\Models\User::attemptGraphQLLogin($this->argument('email'), $this->argument('password'));
        $this->info(json_encode($response));
    }
}
