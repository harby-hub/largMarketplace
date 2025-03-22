<?php namespace Modules\Authentication\Mail;

use Modules\Authentication\Models\Pincode;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class SendPincodeMail extends Mailable {

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct( public Pincode $Pincode ) {
        $this -> Pincode = $Pincode ;
    }
    /**
     * Build the message.
     */
    public function build( ) : self {
        return $this -> to( $this -> Pincode -> unique ) -> view( 'Authentication::SendPincodeMail' , [ 'data' => [ 'pincode' => $this -> Pincode -> pincode ] + $this -> Pincode -> toArray( ) ] );
    }

}
