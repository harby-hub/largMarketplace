<?php namespace Modules\Authentication\Tests\Client;

class LogoutTest extends \Modules\Authentication\Tests\TestCase {
    public function testLogoutApi( ) {
        $Client = \Modules\Authentication\Models\Client::factory( ) -> create( ) ;
        $response    = $this -> Login ( [ 'provider' => 'Client' , 'attempt' => [
            'email'    => $Client -> email ,
            'password' => 'password1A'
        ] ] ) ;

        $this
            -> withToken          ( $response -> json( 'data.authenticationLogin.token.access_token' ) )
            -> Logout             ( )
            -> AssertOkSuccessful ( 'authenticationLogout' )
        ;
        $this -> AssertEmpty( $Client -> refresh( ) -> tokens ) ;
        \Modules\Authentication\Services\Authentication::forgetGuards( ) ;
        $this
            -> withToken                 ( $response -> json( 'data.authenticationLogin.token.access_token' ) )
            -> me                        ( )
            -> assertResponseUnAuthorized( )
        ;
    }
}