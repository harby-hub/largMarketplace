<?php namespace Modules\Atom\GraphQL\Scalars;

use Carbon\Carbon;
use Exception;
use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Utils\Utils;

abstract class DateScalar extends type {

    public String $pattern ;

    /**
     * Serialize the Carbon instance.
     */
    abstract protected function format( Carbon $carbon ) : string ;

	public function __construct( ) {
		$this -> description = class_basename( static::class ) . ' ' . $this -> pattern . ' pattern' ;
	}

    /**
     * Serialize an internal value, ensuring it is a valid date string.
     *
     * @param  \Carbon\Carbon|string  $value
     */
    public function serialize( $value ) : string {
        if ( ! $value instanceof Carbon ) $value = $this -> tryParsingDate( $value , InvariantViolation::class );
        return $this -> format( $value );
    }

    /**
     * Parse a externally provided variable value into a Carbon instance.
     *
     * @param  string  $value
     */
    public function parseValue( $value ) : Carbon {
        return $this -> tryParsingDate( $value , Error::class );
    }

    /**
     * Parse a literal provided as part of a GraphQL query string into a Carbon instance.
     *
     * @param  \GraphQL\Language\AST\Node  $valueNode
     * @param  mixed[]|null  $variables
     *
     * @throws \GraphQL\Error\Error
     */
    public function parseLiteral( $valueNode , ? array $variables = null ) : Carbon {
        if ( ! $valueNode instanceof StringValueNode ) throw new Error( "Query error: Can only parse strings, got {$valueNode->kind}" , $valueNode );
        return $this -> tryParsingDate( $valueNode -> value , Error::class );
    }

    /**
     * Try to parse the given value into a Carbon instance, throw if it does not work.
     *
     * @param  string  $value
     * @param  class-string<\Exception>  $exceptionClass
     *
     * @throws \GraphQL\Error\InvariantViolation|\GraphQL\Error\Error
     */
    protected function tryParsingDate( $value , string $exceptionClass ): Carbon {
        try {
            return $this -> parse( $value );
        } catch ( Exception $e ) {
            throw new $exceptionClass( Utils::printSafeJson( $e -> getMessage( ) ) );
        }
    }

    protected function parse( $value ) : Carbon {
        return Carbon::createFromFormat( $this -> pattern , $value );
    }

}
