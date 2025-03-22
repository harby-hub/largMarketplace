<?php namespace Modules\Authentication\Models\Passport; class RefreshToken extends \Laravel\Passport\RefreshToken {
    protected $table = 'oauth_refresh_tokens' ;
}