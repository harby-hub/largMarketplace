<?php namespace Modules\Authentication\Tests\Delegate;

use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Tests\TestCase ;
use Modules\Delivering\Models\Delegate;

class UpdateTest extends TestCase {

    public function testUpdateCase( ) {
        $Delegate = Delegate :: Factory( ) -> create ( ) ;
        $UserAuth     = $Delegate -> getAuthenticationModel( ) ;
        $password     = 'password1ANew' ;
        $raw          = [ 'password' => $password ] + Delegate::Factory( ) -> raw( ) ;
        unset( $raw[ 'active' ] , $raw[ 'name' ] ) ;
        $this -> Update ( $raw ) -> assertResponseUnAuthorized ( ) ;
        $this
            -> actingAs    ( $UserAuth )
            -> Update      ( $raw      )
            -> AssertOkData( 'authenticationUpdate' , [ 'provider' => 'Delegate' , 'authentication' => [
                'id'    => $Delegate -> id ,
                'email' => $raw[ 'email' ]
            ] ] )
        ;
        $Response = $this -> Login ( [ 'provider' => 'Delegate' , 'attempt' => [
            'email'    => $raw[ 'email' ] ,
            'password' => $password
        ] ] );
        $this
            -> withToken   ( $Response -> json( 'data.authenticationLogin.token.refresh_token' ) )
            -> Me          ( )
            -> AssertOkData( 'me' , [ 'provider' => 'Delegate' , 'authentication' => [
                'id'            => $UserAuth -> id            ,
                'email'         => $UserAuth -> email         ,
                'need_password' => $UserAuth -> need_password ,
                'active'        => $UserAuth -> active        ,
            ] ] )
        ;
        $this -> assertFalse( $Delegate -> password === $Delegate -> refresh( ) -> password ) ;
        $this -> assertTrue( Hash::check( $password , $Delegate -> refresh( ) -> password ) ) ;
    }
}