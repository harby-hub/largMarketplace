<?php namespace Modules\Authentication\Tests\Staff;

use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Tests\TestCase ;
use Modules\Administration\Models\Staff;

class UpdateTest extends TestCase {

    public function testUpdateCase( ) {
        $Staff = Staff :: Factory( ) -> create ( ) ;
        $UserAuth     = $Staff -> getAuthenticationModel( ) ;
        $password     = 'password1ANew' ;
        $raw          = [ 'password' => $password ] + Staff::Factory( ) -> raw( ) ;
        unset( $raw[ 'active' ] , $raw[ 'name' ] ) ;
        $this -> Update ( $raw ) -> assertResponseUnAuthorized ( ) ;
        $this
            -> actingAs    ( $UserAuth )
            -> Update      ( $raw      )
            -> AssertOkData( 'authenticationUpdate' , [ 'provider' => 'Staff' , 'authentication' => [
                'id'    => $Staff -> id ,
                'email' => $raw[ 'email' ]
            ] ] )
        ;
        $Response = $this -> Login ( [ 'provider' => 'Staff' , 'attempt' => [
            'email'    => $raw[ 'email' ] ,
            'password' => $password
        ] ] );
        $this
            -> withToken   ( $Response -> json( 'data.authenticationLogin.token.refresh_token' ) )
            -> Me          ( )
            -> AssertOkData( 'me' , [ 'provider' => 'Staff' , 'authentication' => [
                'id'            => $UserAuth -> id            ,
                'email'         => $UserAuth -> email         ,
                'need_password' => $UserAuth -> need_password ,
                'active'        => $UserAuth -> active        ,
            ] ] )
        ;
        $this -> assertFalse( $Staff -> password === $Staff -> refresh( ) -> password ) ;
        $this -> assertTrue( Hash::check( $password , $Staff -> refresh( ) -> password ) ) ;
    }
}