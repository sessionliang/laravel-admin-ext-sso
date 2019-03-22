<?php

namespace DM\SSO\Console\Commands;

use Illuminate\Console\Command;
use DM\SSO\Models\SsoClient;

class CreateSsoClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sso:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建一个sso client';

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
        $domain = $this->ask('the sso client domain ?');

        $app_id = strtolower('sso'.str_random('13'));

        $app_secret = md5($app_id.time());

        $sso_client = new SsoClient;
        $sso_client->domain = $domain;
        $sso_client->app_id = $app_id;
        $sso_client->app_secret = $app_secret;
        $sso_client->save();

        $this->info('Create sso client successfully! Copy the app id and app secret to sso.config.');
        $this->table(['name', 'app id', 'secret'], [[$domain, $app_id, $app_secret]]);
    }
}
