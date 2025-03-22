<?php namespace Modules\Authentication\Tests\Delegate;

use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Models\Delegate;

class ResetPasswordTest extends \Modules\Authentication\Tests\TestCase {

    public function testRegisterApi( ) {

        $provider         = class_basename ( Delegate::class ) ;
        $Delegate     = Delegate :: Factory( ) -> create ( ) ;
        $DelegateMake = Delegate :: Factory( ) -> raw    ( ) ;
        $Pincode          = $this -> makePincode ( $Delegate -> email ) -> getNewToken( );

        $this
            -> ResetPassword ( [
                'provider'           => $provider ,
                'password'           => 'password1A' ,
                'verifyPinCodeInput' => [ 'email' => $DelegateMake [ 'email' ] , 'code' => '21321121' ] ,
            ] )
            -> assertResponseUnAuthorized ( )
        ;

        $this
            -> ResetPassword( [
                'provider'           => $provider ,
                'password'           => 'password1Adddd' ,
                'verifyPinCodeInput' => [ 'email' => $Delegate -> email , 'code' => $Pincode -> token ] ,
            ] )
            -> AssertOkSuccessful ( 'authenticationResetPassword' )
        ;
        $this -> assertFalse( $Delegate -> password === $Delegate -> refresh( ) -> password ) ;
        $this -> assertTrue( Hash::check( 'password1Adddd' , $Delegate -> refresh( ) -> password ) ) ;
    }
}