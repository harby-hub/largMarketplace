<?php namespace Modules\Atom\GraphQL\Queries;
use Illuminate\Http\Resources\Json\JsonResource;
class Atom {
    use \Modules\Atom\GraphQL\Services\Result  ;
    function namespaces ( $_ , Array $Arguments = [ ] ) : JsonResource {
        return $this -> Successful ( \Illuminate\Support\Facades\Config::get( 'lighthouse.namespaces' ) ) ;
    }
    function Module ( $_ , Array $Arguments = [ ] ) : JsonResource {
        return $this -> Successful ( [ 'data' => \Nwidart\Modules\Facades\Module::toCollection ( )
            -> map( fn( \Nwidart\Modules\Laravel\Module $Module ) => $Module -> json( ) -> getAttributes( ) )
            -> sortBy( 'priority' )
        ] ) ;
    }
    function Health ( $_ , Array $Arguments = [ ] ) : JsonResource {
        return $this -> ok ( 'good' ) ;
    }
}
