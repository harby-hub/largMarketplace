<?php namespace Modules\Atom\GraphQL\Scalars\Date;

use Carbon\Carbon;

use Modules\Atom\GraphQL\Scalars\DateScalar ;

class Date extends DateScalar {

    public string $name = "Date" ;
    public string $pattern = 'Y-m-d' ;

    protected function format( Carbon $carbon ) : string {
        return $carbon -> toDateString( );
    }

}
