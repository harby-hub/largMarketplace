<?php namespace Modules\Atom\GraphQL\Scalars\Date;

use Carbon\Carbon;

use Modules\Atom\GraphQL\Scalars\DateScalar ;

class Time extends DateScalar {

    public string $name    = "Time" ;
    public string $pattern = 'H:i:s' ;

    protected function format( Carbon $carbon ) : string {
        return $carbon -> toTimeString( );
    }

}
