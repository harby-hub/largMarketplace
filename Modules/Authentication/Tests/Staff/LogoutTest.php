<?php namespace Modules\Authentication\Tests\Staff;

class LogoutTest extends \Modules\Authentication\Tests\TestCase {
    public function testLogoutApi( ) {
        $Staff = \Modules\Authentication\Models\Staff::factory( ) -> create( ) ;
        $response     = $this -> Login ( [ 'provider' => 'Staff' , 'attempt' => [
            'email'    => $Staff -> email ,
            'password' => 'password1A'
        ] ] ) ;

        $this
            -> withToken          ( $response -> json( 'data.authenticationLogin.token.access_token' ) )
            -> Logout             ( )
            -> AssertOkSuccessful ( 'authenticationLogout' )
        ;
        $this -> AssertEmpty( $Staff -> refresh( ) -> tokens ) ;
        \Modules\Authentication\Services\Authentication::forgetGuards( ) ;
        $this
            -> withToken                 ( $response -> json( 'data.authenticationLogin.token.access_token' ) )
            -> me                        ( )
            -> assertResponseUnAuthorized( )
        ;
    }
}