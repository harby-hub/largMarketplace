<?php namespace Modules\Atom\GraphQL\Directives\Bilders;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;

class BilderCounterDirective extends BaseDirective implements ArgBuilderDirective {

    public static function definition( ) : string {
        return 'BilderCounter' ;
    }

    public function handleBuilder( $builder , $value ) : EloquentBuilder|Relation|QueryBuilder {
        return $builder -> take( $value );
    }

}