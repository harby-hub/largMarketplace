<?php namespace Modules\Authentication\Tests\Delegate;

class MeTest extends \Modules\Authentication\Tests\TestCase {

    public function testMeBaseApi( ) {
        $this
            -> Me                         ( )
            -> assertResponseUnAuthorized ( )
        ;
        $this
            -> actingAs     ( $Delegate = \Modules\Authentication\Models\Delegate::factory( ) -> create( ) )
            -> Me           ( )
            -> AssertOkData ( 'me' , [ 'provider' => 'Delegate' , 'authentication' => [
                'id'         => $Delegate -> id                                ,
                'email'      => $Delegate -> email                             ,
                'updated_at' => $Delegate -> updated_at -> toDateTimeString( ) ,
                'created_at' => $Delegate -> created_at -> toDateTimeString( ) ,
            ] ] )
        ;
    }
}