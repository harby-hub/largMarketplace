<?php namespace Modules\Atom\GraphQL\Scalars\Date;

use Carbon\Carbon;

use Modules\Atom\GraphQL\Scalars\DateScalar ;

class DateTime extends DateScalar {

    public string $name = "DateTime" ;
    public string $pattern = Carbon::DEFAULT_TO_STRING_FORMAT ;

    protected function format( Carbon $carbon ) : string {
        return $carbon -> toDateTimeString( );
    }

}
