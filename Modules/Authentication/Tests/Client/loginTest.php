<?php namespace Modules\Authentication\Tests\Client;

use Modules\Authentication\Models\Client;

class loginTest extends \Modules\Authentication\Tests\TestCase {

    public function testLoginBaseWithEmailApi( ) {
        
        $this
            -> Login        ( [ 'provider' => 'Client' , 'attempt' => [
                'email'    => $this -> faker( ) -> email ,
                'password' => 'passwoascrd1A'
            ] ] )
            -> assertResponseUnAuthorized( )
        ;
        $Client = Client::factory( ) -> create( ) ;
        $this
            -> Login( [ 'provider' => 'Client' , 'attempt' => [
                'email'    => $Client -> email ,
                'password' => 'password1A'
            ] ] )
            -> AssertOkData( 'authenticationLogin' , [ 'provider' => 'Client' , 'authentication' => [
                'id'         => $Client -> id ,
                'email'      => $Client -> email ,
                'active'     => $Client -> active ,
                'updated_at' => $Client -> updated_at -> toDateTimeString( ),
                'created_at' => $Client -> created_at -> toDateTimeString( ),
            ] ] )
            -> AssertJsonStructureToken( 'authenticationLogin' )
        ;
        $this
            -> Me( )
            -> assertResponseUnAuthorized( )
        ;
    }

}