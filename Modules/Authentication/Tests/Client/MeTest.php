<?php namespace Modules\Authentication\Tests\Client;

class MeTest extends \Modules\Authentication\Tests\TestCase {

    public function testMeBaseApi( ) {
        $this
            -> Me                         ( )
            -> assertResponseUnAuthorized ( )
        ;
        $this
            -> actingAs     ( $Client = \Modules\Authentication\Models\Client::factory( ) -> create( ) )
            -> Me           ( )
            -> AssertOkData ( 'me' , [ 'provider' => 'Client' , 'authentication' => [
                'id'         => $Client -> id                                ,
                'email'      => $Client -> email                             ,
                'updated_at' => $Client -> updated_at -> toDateTimeString( ) ,
                'created_at' => $Client -> created_at -> toDateTimeString( ) ,
            ] ] )
        ;
    }
}