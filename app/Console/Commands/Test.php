<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:aa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A test';

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
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('What is your name?');
        $account = $this->ask('What is your account?');
        $password = $this->secret('What is the password?(min: 6 character)');

        $data = [
            'name' => $name,
            'account' => $account,
            'password' => $password
        ];

//        $user = $this->register($data);
        $this->info($data['name']);
//        if ( $user ) {
//            $this->info('Register a new admin success! You can login in the dashboard by the account.');
//        } else {
//            $this->error('Something went wrong!');
//        }
    }

    public function register($data)
    {

    }
}
