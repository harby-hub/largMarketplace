<?php namespace Modules\Authentication\Tests\Client;

use Modules\Authentication\Tests\TestCase ;
use Modules\Seller\Models\Client;

class RegisterTest extends TestCase {

    public function testRegisterApi( ) {
        $provider   = class_basename ( Client::class )   ;
        $ClientMake = Client :: Factory( ) -> raw    ( ) ;
        $Client     = Client :: Factory( ) -> create ( ) ;

        $Pincode  = $this -> makePincode ( $ClientMake [ 'email' ] ) -> getNewToken( ) ;
        $PincodeS = $this -> makePincode ( $Client     -> email    ) -> getNewToken( ) ;

        $this
            -> Register ( [
                'provider'   => $provider ,
                'userInputs' => [
                    'password' => 'password1A'
                ],
                'verifyPinCodeInput' => [
                    'email' => $Client -> email ,
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
                    'email' => $ClientMake [ 'email' ] ,
                    'code'  => $Pincode -> token ,
                ],
            ] )
            -> AssertOkData       ( 'authenticationRegister' , [ 'provider' => 'Client' , 'authentication' => [
                'email'         => $ClientMake [ 'email' ] ,
                'need_password' => false ,
                'active'        => false ,
            ] ] )
            -> AssertJsonStructureToken ( 'authenticationRegister' )
        ;
    }
}