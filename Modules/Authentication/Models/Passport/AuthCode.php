<?php namespace Modules\Authentication\Models\Passport; class AuthCode extends \Laravel\Passport\AuthCode {
    protected $table = 'oauth_auth_codes' ;
}