<?php namespace Modules\Atom\GraphQL\Scalars;

use Modules\Atom\GraphQL\Consts\regularExpression;

class HexadecimalColorWithAlpha extends type {

    public string $name = "HexadecimalColorWithAlpha" ;

	public function parseValue( $value ) {
		if ( ! preg_match( regularExpression::HEXADECIMALCOLORWITHALPHAEGEX , $value ) ) $this -> Error( "Cannot represent following value as color:$this->printSafeJson( $value )" );
		return $value ;
	}

}