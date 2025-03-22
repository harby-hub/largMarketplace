<?php namespace Modules\Authentication\Tests\Staff;

use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Models\Staff;

class ResetPasswordTest extends \Modules\Authentication\Tests\TestCase {

    public function testRegisterApi( ) {

        $provider         = class_basename ( Staff::class ) ;
        $Staff     = Staff :: Factory( ) -> create ( ) ;
        $StaffMake = Staff :: Factory( ) -> raw    ( ) ;
        $Pincode          = $this -> makePincode ( $Staff -> email ) -> getNewToken( );

        $this
            -> ResetPassword ( [
                'provider'           => $provider ,
                'password'           => 'password1A' ,
                'verifyPinCodeInput' => [ 'email' => $StaffMake [ 'email' ] , 'code' => '21321121' ] ,
            ] )
            -> assertResponseUnAuthorized ( )
        ;

        $this
            -> ResetPassword( [
                'provider'           => $provider ,
                'password'           => 'password1Adddd' ,
                'verifyPinCodeInput' => [ 'email' => $Staff -> email , 'code' => $Pincode -> token ] ,
            ] )
            -> AssertOkSuccessful ( 'authenticationResetPassword' )
        ;
        $this -> assertFalse( $Staff -> password === $Staff -> refresh( ) -> password ) ;
        $this -> assertTrue( Hash::check( 'password1Adddd' , $Staff -> refresh( ) -> password ) ) ;
    }
}