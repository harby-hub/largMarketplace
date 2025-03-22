<?php namespace Modules\Atom\GraphQL\Scalars\Text;

use Modules\Atom\GraphQL\Scalars\type ;
use Illuminate\Support\Facades\Hash;
use Modules\Atom\GraphQL\Consts\regularExpression;

class Password extends type {
    public string $name = "Password" ;

	public function parseValue( $value ) {
		if ( ! preg_match( regularExpression::PASSWORDREGEX , $value ) ) $this -> Error( "Cannot represent following value as Password: $this->printSafeJson($value)" );
		return Hash::make( $value );
	}

}
