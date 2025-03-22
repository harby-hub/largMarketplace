<?php namespace Modules\Authentication\Tests\Delegate;

use Modules\Authentication\Tests\TestCase ;
use Modules\Delivering\Models\Delegate;

class RegisterTest extends TestCase {

    public function testRegisterApi( ) {
        $provider     = class_basename ( Delegate::class )   ;
        $DelegateMake = Delegate :: Factory( ) -> raw    ( ) ;
        $Delegate     = Delegate :: Factory( ) -> create ( ) ;

        $Pincode  = $this -> makePincode ( $DelegateMake [ 'email' ] ) -> getNewToken( );
        $PincodeS = $this -> makePincode ( $Delegate     -> email    ) -> getNewToken( );

        $this
            -> Register ( [
                'provider'   => $provider ,
                'userInputs' => [
                    'password' => 'password1A'
                ],
                'verifyPinCodeInput' => [
                    'email' => $Delegate -> email ,
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
                    'email' => $DelegateMake [ 'email' ] ,
                    'code'  => $Pincode -> token ,
                ],
            ] )
            -> AssertOkData       ( 'authenticationRegister' , [ 'provider' => 'Delegate' , 'authentication' => [
                'email'         => $DelegateMake [ 'email' ] ,
                'need_password' => false ,
                'active'        => false ,
            ] ] )
            -> AssertJsonStructureToken ( 'authenticationRegister' )
        ;
    }
}