<?php namespace Modules\Atom\GraphQL\Scalars;

use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Language\AST\Node;

abstract class type extends ScalarType {

	public function serialize( $value ) : mixed {
		return $value ;
	}

	public function serialize_string( string $value ) : string {
		return mb_substr( htmlspecialchars( $value , ENT_NOQUOTES , 'utf-8' , false ) , 0 , $this -> max );
	}

	public function Error( string $message , $nodes = null ) : void {
		throw new Error( $message , $nodes );
	}

	public function printSafeJson( $var ) : string {
        if ( $var instanceof stdClass ) $var = ( array ) $var ;
        if ( is_array(  $var ) ) return json_encode( $var )      ;
        if ( $var === ''       ) return '(empty string)'         ;
        if ( $var === null     ) return 'null'                   ;
        if ( $var === false    ) return 'false'                  ;
        if ( $var === true     ) return 'true'                   ;
        if ( is_string( $var ) ) return sprintf( '"%s"' , $var ) ;
        if ( is_scalar( $var ) ) return ( string ) $var          ;
        return gettype( $var );
	}

	public function parseLiteral( Node $valueNode, ?array $variables = NULL ) {
		if ( ! $valueNode instanceof StringValueNode ) $this -> Error( 'Query error: Can only parse strings got: ' . $valueNode -> kind , [ $valueNode ] );
		return $valueNode -> value;
	}

}