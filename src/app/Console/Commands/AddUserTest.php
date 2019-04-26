<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use phpQuery;

function generateRandomPassword()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

class AddUserTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:addUser {name} {email} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user';

    protected $registerUrl = 'http://nginx/register';

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
        $password = $this->option('password') ? $this->option('password') : generateRandomPassword();
        $sessionInfomation = $this->getSessionInfomation();

        $request_data = array(
            '_token'  => $sessionInfomation->csrfToken,
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $password,
            'password_confirmation' => $password
        );

        $header = (
            "Content-type: application/x-www-form-urlencoded\r\n"
          . "Cookie: " . implode(";", $sessionInfomation->cookies) . "\r\n"
        );

        $this->line('Name      : ' . $request_data['name']);
        $this->line('Email     : ' . $request_data['email']);
        $this->line('Password  : ' . $request_data['password']);

        $options = array(
            'http' => array(
                'header'  => $header,
                'method'  => 'POST',
                'content' => http_build_query($request_data),
            )
        );

        $context  = stream_context_create($options);
        $html = file_get_contents($this->registerUrl, false, $context);

        $validationErrors = phpQuery::newDocument($html)->find('.help-block')->find('strong')->text();
        if ($validationErrors) {
            $this->error("\nvalidation errors");
            $this->info($validationErrors);
        } else {
            $this->info('Success');
        };

        // var_dump($result);
    }

    protected function getSessionInfomation()
    {
        $html = file_get_contents($this->registerUrl);

        $cookies = [];
        foreach ($http_response_header as $s) {
            if (preg_match("/Set-Cookie:\s*([^=]+)=([^;]+);(.+)/u", $s, $parts)) {
                $cookies[] = $parts[1] . '=' . $parts[2];
            }
        }

        $csrfTokenElement = phpQuery::newDocument($html)->find("form")->find(':input[name=_token]');
        return (object) array(
            "cookies" => $cookies,
            "csrfToken" => $csrfTokenElement->val()
        );
    }
}
