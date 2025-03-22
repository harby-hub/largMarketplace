<?php namespace Modules\Authentication\Tests\Delegate;

use Modules\Authentication\Models\Delegate;

class loginTest extends \Modules\Authentication\Tests\TestCase {

    public function testLoginBaseWithEmailApi( ) {
        $this
            -> Login        ( [ 'provider' => 'Delegate' , 'attempt' => [
                'email'    => $this -> faker( ) -> email ,
                'password' => 'passwoascrd1A'
            ] ] )
            -> assertResponseUnAuthorized( )
        ;
        $Delegate = Delegate::factory( ) -> create( ) ;
        $response = $this
            -> Login ( [ 'provider' => 'Delegate' , 'attempt' => [
                'email'    => $Delegate -> email ,
                'password' => 'password1A'
            ] ] )
            -> AssertOkData( 'authenticationLogin' , [ 'provider' => 'Delegate' , 'authentication' => [
                'id'         => $Delegate -> id ,
                'email'      => $Delegate -> email ,
                'active'     => $Delegate -> active ,
                'updated_at' => $Delegate -> updated_at -> toDateTimeString( ),
                'created_at' => $Delegate -> created_at -> toDateTimeString( ),
            ] ] )
            -> AssertJsonStructureToken ( 'authenticationLogin' )
        ;
        $this
            -> Me( )
            -> assertResponseUnAuthorized( )
        ;
        $this
            -> withToken( $response -> json( 'data.authenticationLogin.token.access_token' ) )
            -> Me( )
            -> AssertOkData( 'me' , [ 'provider' => 'Delegate' , 'authentication' => [
                'id'         => $Delegate -> id                                ,
                'email'      => $Delegate -> email                             ,
                'updated_at' => $Delegate -> updated_at -> toDateTimeString( ) ,
                'created_at' => $Delegate -> created_at -> toDateTimeString( ) ,
            ] ] )
        ;
    }

}