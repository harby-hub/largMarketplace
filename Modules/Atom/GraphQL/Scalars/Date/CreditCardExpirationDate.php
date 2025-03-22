<?php namespace Modules\Atom\GraphQL\Scalars\Date;

use Carbon\Carbon;

use Modules\Atom\GraphQL\Scalars\DateScalar ;

class CreditCardExpirationDate extends DateScalar {

    public string $name = "CreditCardExpirationDate" ;
    public string $pattern = 'm/Y' ;

    protected function format( Carbon $carbon ) : string {
        return $carbon -> format( $this -> pattern );
    }

}
