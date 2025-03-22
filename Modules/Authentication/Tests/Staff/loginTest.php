<?php namespace Modules\Authentication\Tests\Staff;

use Modules\Authentication\Models\Staff;

class loginTest extends \Modules\Authentication\Tests\TestCase {

    public function testLoginBaseWithEmailApi( ) {
        $this
            -> Login        ( [ 'provider' => 'Staff' , 'attempt' => [
                'email'    => $this -> faker( ) -> email ,
                'password' => 'passwoascrd1A'
            ] ] )
            -> assertResponseUnAuthorized( )
        ;
        $this
            -> Login ( [ 'provider' => 'Staff' , 'attempt' => [
                'email'    => ( $Staff = Staff::factory( ) -> create( ) ) -> email ,
                'password' => 'password1A'
            ] ] )
            -> AssertOkData( 'authenticationLogin' , [ 'provider' => 'Staff' , 'authentication' => [
                'id'         => $Staff -> id ,
                'email'      => $Staff -> email ,
                'active'     => $Staff -> active ,
                'updated_at' => $Staff -> updated_at -> toDateTimeString( ),
                'created_at' => $Staff -> created_at -> toDateTimeString( ),
            ] ] )
            -> AssertJsonStructureToken ( 'authenticationLogin' )
        ;
        $this
            -> Me( )
            -> assertResponseUnAuthorized( )
        ;
    }

}