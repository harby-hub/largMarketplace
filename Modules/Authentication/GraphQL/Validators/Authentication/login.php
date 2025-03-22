<?php namespace Modules\Authentication\GraphQL\Validators\Authentication;
use Modules\Atom\GraphQL\Validators\Validator as base;
class login extends base {
    public function rules( ) : array { return [
        'attempt.email'    => $this -> Email    ( [ ] ) ,
        'attempt.password' => $this -> Password ( [ 'required'               ] ) ,
    ]; }
}
