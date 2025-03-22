<?php namespace Modules\Atom\GraphQL\Scalars;

abstract class Text extends type {

	public function __construct( ) {
		$this -> description = "like normal string but limit from $this->min to $this->max characters" ;
	}

	public function serialize( $value ) : string {
		return $this -> serialize_string( $value ) ;
	}

	public function parseValueReturn( string $value ) : string {
		return htmlspecialchars( $value , ENT_NOQUOTES , 'utf-8' , false );
	}

}