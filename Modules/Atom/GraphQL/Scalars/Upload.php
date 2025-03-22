<?php namespace Modules\Atom\GraphQL\Scalars;

use GraphQL\Error\InvariantViolation;
use Illuminate\Http\UploadedFile;

class Upload extends type {

    public string $name = "Upload" ;

    public function serialize( $value ) : string {
        throw new InvariantViolation( '"Upload" cannot be serialized, it can only be used as an argument.' );
    }

    public function parseValue( $value ) : UploadedFile {
        if ( ! $value instanceof UploadedFile ) $this -> Error( 'Could not get uploaded file, be sure to conform to GraphQL multipart request specification: https://github.com/jaydenseric/graphql-multipart-request-spec Instead got: ' . $this -> printSafe( $value ) );
        return $value;
    }

    public function parseLiteral( $valueNode , array $variables = null ) : void {
        $this -> Error( '"Upload" cannot be hardcoded in a query. Be sure to conform to the GraphQL multipart request specification: https://github.com/jaydenseric/graphql-multipart-request-spec' );
    }
}
