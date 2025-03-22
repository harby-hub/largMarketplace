<?php namespace Modules\Atom\GraphQL\Scalars;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class Email extends type {

    public  string $name        = "Email"                                                              ;
    public ?string $description = 'A [RFC 5321](https://tools.ietf.org/html/rfc5321) compliant email.' ;

	public function parseValue( $value ) {
		if ( ! $this -> isValid( $value ) ) $this -> Error( "Cannot represent following value as color:$this->printSafeJson($value)" );
		return $value ;
    }

    protected function isValid( string $stringValue ) : bool {
        return ( new EmailValidator( ) ) -> isValid( $stringValue , new RFCValidation( ) );
    }
}
