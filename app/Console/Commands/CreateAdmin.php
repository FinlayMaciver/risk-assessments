<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risk-assessments:createadmin {guid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds an admin to the system via GUID';

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
        $user = \Ldap::findUser($this->argument('guid'));
        if (! $user) {
            $this->error('User not found!');
        }
        User::updateOrCreate(
            [
            'guid' => $this->argument('guid'),
        ],
            [
            'is_staff' => true,
            'is_admin' => true,
            'forenames' => $user['forenames'],
            'surname' => $user['surname'],
            'email' => Str::lower($user['email']),
        ]
        );
        $this->info('User added!');
    }
}
