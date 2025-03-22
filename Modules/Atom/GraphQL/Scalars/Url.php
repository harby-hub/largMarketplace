<?php namespace Modules\Atom\GraphQL\Scalars;

use Modules\Atom\GraphQL\Consts\regularExpression;

class Url extends type {

	public string $name = "Url" ;

	public function parseValue( $value ) {
		if ( empty( $value ) ) return '' ;
		$value = filter_var( $value , FILTER_SANITIZE_URL ) ;
		if ( ! preg_match( regularExpression::URLREGEX , $value ) ) $this -> Error( "Cannot represent following value as Url: " . $this -> printSafeJson( $value ) );
		return $value ;
	}

}