<?php namespace Modules\Authentication\Tests\Staff;

class MeTest extends \Modules\Authentication\Tests\TestCase {

    public function testMeBaseApi( ) {
        $this
            -> Me                         ( )
            -> assertResponseUnAuthorized ( )
        ;
        $this
            -> actingAs     ( $Staff = \Modules\Authentication\Models\Staff::factory( ) -> create( ) )
            -> Me           ( )
            -> AssertOkData ( 'me' , [ 'provider' => 'Staff' , 'authentication' => [
                'id'         => $Staff -> id                                ,
                'email'      => $Staff -> email                             ,
                'updated_at' => $Staff -> updated_at -> toDateTimeString( ) ,
                'created_at' => $Staff -> created_at -> toDateTimeString( ) ,
            ] ] )
        ;
    }
}