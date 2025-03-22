<?php namespace Modules\Authentication\Tests;

use Illuminate\Foundation\Testing\WithFaker;

use Modules\Authentication\Tests\Traits\{
    Me            ,
    Login         ,
    Update        ,
    PinCode       ,
    ResetPassword ,
    RefreshToken  ,
    Register      ,
    Logout
};

class TestCase extends \Modules\Atom\Tests\TestCase {

    use
        PinCode       ,
        Login         ,
        Update        ,
        Register      ,
        Me            ,
        Logout        ,
        RefreshToken  ,
        ResetPassword ,
        WithFaker
    ;

    public $Token = 'token{
		access_token
		refresh_token
		expires_in
		token_type
	}' ;

    public $user = 'authentication{
        ... on User {
            id
            need_password
            email
            active
            updated_at
            created_at
        }
	}';

}