<?php namespace Modules\Authentication\Models\Passport; class Client extends \Laravel\Passport\Client {
    protected $table = 'oauth_clients' ;
}