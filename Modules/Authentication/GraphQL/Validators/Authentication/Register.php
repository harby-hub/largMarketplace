<?php namespace Modules\Authentication\GraphQL\Validators\Authentication; class Register extends \Modules\Atom\GraphQL\Validators\Validator {
    public function rules( ) : array { return [
        'userInputs.name'              => $this -> text        ( ) ,
        'userInputs.password'          => $this -> Text        ( ) ,
        'userInputs.email'             => $this -> EmailUnique ( [ ] ) ,
        'accessTokenInput.firebase_id' => $this -> firebase_id  ( ) ,
        'verifyPinCodeInput.email'     => $this -> EmailUnique ( [ ] ) ,
    ] ; }

}