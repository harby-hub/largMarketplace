<?php namespace Modules\Authentication\GraphQL\Validators\PinCode; class sendRequest extends \Modules\Atom\GraphQL\Validators\Validator {
    public function rules( ) : array { return [
        'email' => $this -> Email( [ ] ) ,
    ]; }
}