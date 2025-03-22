<?php namespace Modules\Authentication\Tests\Client;

use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Tests\TestCase ;
use Modules\Seller\Models\Client;

class UpdateTest extends TestCase {

    public function testUpdateCase( ) {
        $Client = Client :: Factory( ) -> create ( ) ;
        $UserAuth    = $Client -> getAuthenticationModel( ) ;
        $password    = 'password1ANew' ;
        $raw         = [ 'password' => $password ] + Client::Factory( ) -> raw( ) ;
        unset( $raw[ 'active' ] , $raw[ 'name' ] ) ;
        $this -> Update( $raw ) -> assertResponseUnAuthorized ( ) ;
        $this
            -> actingAs    ( $UserAuth )
            -> Update      ( $raw      )
            -> AssertOkData( 'authenticationUpdate' , [ 'provider' => 'Client' , 'authentication' => [
                'id'       => $Client -> id ,
                'email'    => $raw[ 'email' ]
            ] ] )
        ;
        $Response = $this -> Login ( [ 'provider' => 'Client' , 'attempt' => [
            'email'    => $raw[ 'email' ] ,
            'password' => $password
        ] ] );
        $this
            -> withToken   ( $Response -> json( 'data.authenticationLogin.token.refresh_token' ) )
            -> Me          ( )
            -> AssertOkData( 'me' , [ 'provider' => 'Client' , 'authentication' => [
                'id'            => $UserAuth -> id            ,
                'email'         => $UserAuth -> email         ,
                'need_password' => $UserAuth -> need_password ,
                'active'        => $UserAuth -> active        ,
            ] ] )
        ;
        $this -> assertFalse( $Client -> password === $Client -> refresh( ) -> password ) ;
        $this -> assertTrue( Hash::check( $password , $Client -> refresh( ) -> password ) ) ;
    }
}