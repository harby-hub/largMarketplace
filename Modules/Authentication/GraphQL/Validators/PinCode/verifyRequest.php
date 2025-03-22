<?php namespace Modules\Authentication\GraphQL\Validators\PinCode; class verifyRequest extends \Modules\Atom\GraphQL\Validators\Validator {
    public function rules( ) : array { return [
        'email' => $this -> Email  ( ) ,
        'code'  => $this -> Text   ( [ 'required' , 'size:' . \Illuminate\Support\Facades\Config::get( 'authentication.pincode.length_pincode_token' ) ] ),
    ]; }
}