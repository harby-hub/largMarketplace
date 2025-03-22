<?php namespace Modules\Atom\GraphQL\Scalars\Text;

use Modules\Atom\GraphQL\Scalars\Text as base ;

class Text extends base {

	public $min  = null   ;
	public $max  = 65534  ;
	public string $name = "Text" ;

	public function __construct( ) {

		$this -> description = "like normal string but limit from null to $this->max characters" ;

	}

	public function parseValue( $value ) {
		if ( strlen( $value ) > $this -> max ) $this -> Error( "$this->name can not greater than : $this->max" );
        return $this -> parseValueReturn( $value );
	}

}