<?php namespace Modules\Atom\GraphQL\Scalars;

use GraphQL\Language\AST\Node;

class SerializeFloat extends type {

    public string $name         = "SerializeFloat" ;
    public ?string $description = 'Serialize Float two digit after comma like : 25.23 , 51.01';

    public function number_format( $value ) : Float {
        return floatval( number_format( $value , 2 ) ) ;
    }

    public function serialize( $value ) : Float {
        return $this -> number_format( $value ) ;
    }

    public function parseValue( $value ) : Float {
        return $this -> number_format( $value ) ;
    }

	public function parseValueReturn( string $value ) : Float {
        return $this -> number_format( $value ) ;
	}

    public function parseLiteral( Node $valueNode, ?array $variables = NULL ) : Float {
        if ( ! property_exists( $valueNode , 'value' ) ) $this -> Error( 'Can only parse literals that contain a value, got ' . $this -> number_format( $valueNode ) );
        return $this -> number_format( $valueNode -> value );
    }

}
