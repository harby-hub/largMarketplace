<?php namespace Modules\Authentication\Tests\Staff;

use Modules\Authentication\Tests\TestCase ;
use Modules\Administration\Models\Staff;

class RegisterTest extends TestCase {

    public function testRegisterApi( ) {
        $provider         = class_basename ( Staff::class )   ;
        $StaffMake = Staff :: Factory( ) -> raw    ( ) ;
        $Staff     = Staff :: Factory( ) -> create ( ) ;

        $Pincode  = $this -> makePincode ( $StaffMake [ 'email' ] ) -> getNewToken( );
        $PincodeS = $this -> makePincode ( $Staff     -> email    ) -> getNewToken( );

        $this
            -> Register ( [
                'provider'   => $provider ,
                'userInputs' => [
                    'password' => 'password1A'
                ],
                'verifyPinCodeInput' => [
                    'email' => $Staff -> email ,
                    'code'  => $PincodeS -> token ,
                ],
            ] )
            -> AssertValidation( 'authenticationRegister' , [ 'data.verifyPinCodeInput.email' => [ 'The email has already been taken.' ] ] )
        ;

        $this
            -> Register ( [
                'provider'   => $provider ,
                'userInputs' => [
                    'password' => 'password1A'
                ],
                'verifyPinCodeInput' => [
                    'email' => $StaffMake [ 'email' ] ,
                    'code'  => $Pincode -> token ,
                ],
            ] )
            -> AssertOkData       ( 'authenticationRegister' , [ 'provider' => 'Staff' , 'authentication' => [
                'email'         => $StaffMake [ 'email' ] ,
                'need_password' => false ,
                'active'        => false ,
            ] ] )
            -> AssertJsonStructureToken ( 'authenticationRegister' )
        ;
    }
}