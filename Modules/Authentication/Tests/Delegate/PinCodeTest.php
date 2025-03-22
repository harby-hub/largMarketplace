<?php namespace Modules\Authentication\Tests\Delegate;

use Illuminate\Support\Facades\{Mail,Config};

use Modules\Authentication\Tests\TestCase ;

use Modules\Authentication\Mail\SendPincodeMail ;

class PinCodeTest extends TestCase {

    public function testSendPinCodeFormEmailApi( ) {
        Mail::fake( ) ;
        $this
            -> PinCodeSend        ( [ 'email' => $this -> faker( ) -> unique( ) -> safeEmail ] )
            -> AssertOkSuccessful ( 'authenticationPincodeSend' )
        ;
        Mail::assertSent( SendPincodeMail::class ) ;
    }

    public function testVerifyPinCodeFormEmailApi( ) {
        $this
            -> PinCodeVerify      ( [ 'email' => $email = $this -> faker( ) -> unique( ) -> safeEmail ] )
            -> AssertErrorMmessage( 'Variable "$data" got invalid value {"email":"' . $email . '"}; Field "code" of required type "String!" was not provided.' )
        ;
        $Pincode = $this -> makePincode( $this -> faker( ) -> unique( ) -> safeEmail ) -> getNewToken( );
        $this
            -> PinCodeVerify( [
                'email' => $Pincode -> unique ,
                'code'  => '2132cc11'
            ] )
            -> AssertErrors ( 'authenticationPincodeVerify' , 'pinCodeIsNotMatch.' , [ 'code' => [ 'pinCodeIsNotMatch.' ] ] , code : \Illuminate\Http\JsonResponse::HTTP_NOT_ACCEPTABLE )
        ;
        $Pincode -> updated_at = $Pincode -> updated_at -> subMinutes( Config::get( 'authentication.pincode.tokens_expire_in' ) + 1 ) ;
        $Pincode -> save( ) ;
        $this
            -> PinCodeVerify( [
                'email' => $Pincode -> unique ,
                'code' => $Pincode -> token
            ] )
            -> AssertErrors ( 'authenticationPincodeVerify' , 'pinCodeIsNotActive.' , [ 'code' => [ 'pinCodeIsNotActive.' ] ] , code : \Illuminate\Http\JsonResponse::HTTP_NOT_ACCEPTABLE )
        ;
        $Pincode -> updated_at = $Pincode -> updated_at -> addMinutes( Config::get( 'authentication.pincode.tokens_expire_in' ) + 1 );
        $Pincode -> save( ) ;
        $this
            -> PinCodeVerify      ( [
                'email' => $Pincode -> unique ,
                'code' => $Pincode -> token
            ] )
            -> AssertOkSuccessful ( 'authenticationPincodeVerify' )
        ;
    }
}