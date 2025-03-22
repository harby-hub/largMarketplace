<?php namespace Modules\Authentication\Tests\Client;

use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Models\Client;

class ResetPasswordTest extends \Modules\Authentication\Tests\TestCase {

    public function testRegisterApi( ) {

        $provider        = class_basename ( Client::class ) ;
        $Client     = Client :: Factory( ) -> create ( ) ;
        $ClientMake = Client :: Factory( ) -> raw    ( ) ;
        $Pincode         = $this -> makePincode ( $Client -> email ) -> getNewToken( );

        $this
            -> ResetPassword ( [
                'provider'           => $provider ,
                'password'           => 'password1A' ,
                'verifyPinCodeInput' => [ 'email' => $ClientMake [ 'email' ] , 'code' => '21321121' ] ,
            ] )
            -> assertResponseUnAuthorized ( )
        ;

        $this
            -> ResetPassword( [
                'provider'           => $provider ,
                'password'           => 'password1Adddd' ,
                'verifyPinCodeInput' => [ 'email' => $Client -> email , 'code' => $Pincode -> token ] ,
            ] )
            -> AssertOkSuccessful ( 'authenticationResetPassword' )
        ;
        $this -> assertFalse( $Client -> password === $Client -> refresh( ) -> password ) ;
        $this -> assertTrue( Hash::check( 'password1Adddd' , $Client -> refresh( ) -> password ) ) ;
    }
}