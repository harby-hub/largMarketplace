<?php namespace Modules\Authentication\Tests\Delegate;

class LogoutTest extends \Modules\Authentication\Tests\TestCase {
    public function testLogoutApi( ) {
        $Delegate = \Modules\Authentication\Models\Delegate::factory( ) -> create( ) ;
        $response     = $this -> Login ( [ 'provider' => 'Delegate' , 'attempt' => [
            'email'    => $Delegate -> email ,
            'password' => 'password1A'
        ] ] ) ;

        $this
            -> withToken          ( $response -> json( 'data.authenticationLogin.token.access_token' ) )
            -> Logout             ( )
            -> AssertOkSuccessful ( 'authenticationLogout' )
        ;
        $this -> AssertEmpty( $Delegate -> refresh( ) -> tokens ) ;
        \Modules\Authentication\Services\Authentication::forgetGuards( ) ;
        $this
            -> withToken                 ( $response -> json( 'data.authenticationLogin.token.access_token' ) )
            -> me                        ( )
            -> assertResponseUnAuthorized( )
        ;
    }
}