<?php namespace Modules\Authentication\GraphQL\Validators\Authentication;
use Modules\Atom\GraphQL\Validators\Validator as base;
class ResetPassword extends base {
    public function rules( ) : array {
        return [
            'email'    => $this -> EmailExists ( ) ,
            'password' => $this -> Password    ( [ 'required' ] ) ,
        ] ;
    }
}