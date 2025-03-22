<?php namespace Modules\Authentication\Tests\Traits;

use Illuminate\Support\Facades\Mail ;
use Modules\Authentication\Models\Pincode as Model;
use Modules\Authentication\Mail\SendPincodeMail ;

trait PinCode{

    public function PincodeSendDocs( ) { }

    public function authenticationPincodeSend ( ) : string {
        return "mutation( \$data : sendPinCodeInput! ) {
			authenticationPincodeSend ( data : \$data ) {
				$this->Status
			}
		}";
    }

    public function authenticationPincodeVerify ( ) : string {
        return "mutation( \$data : verifyPinCodeInput! ) {
			authenticationPincodeVerify ( data : \$data ) {
				$this->Status
			}
		}";
    }

    public function PinCodeSend( Array $Array = [ ] ){
        return $this -> GraphQLFiles( $this -> authenticationPincodeSend( ) , [ 'data' => $Array ] );
    }

    public function PinCodeVerify( Array $Array = [ ] ){
        return $this -> GraphQLFiles( $this -> authenticationPincodeVerify( ) , [ 'data' => $Array ] );
    }

    public function makePincode( String $Email = null ) : Model{
        if ( $Email !== Null ) {
            Mail :: fake       (                        ) ;
            $Pincode = Model::toEmail( $Email ) -> getNewToken( ) ;
            Mail :: assertSent ( SendPincodeMail::class ) ;
        } ;
        return $Pincode ;
    }

}