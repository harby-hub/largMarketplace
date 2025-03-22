<?php namespace Modules\Atom\GraphQL\Queries;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Builder;
Abstract class Query {
    use    \Modules\Atom\GraphQL\Services\Result ;
    public \Modules\Atom\Services\Repository $Repository ;
    function Show ( $_ , array $Arguments = [ ] ) : JsonResource {
        return $this -> Successful ( [ 'data' => $this -> Repository -> Query( ) -> find( $Arguments[ 'id' ] ) ] ) ;
    }
    function Index ( $_ , array $Arguments = [ ] ) : Builder {
        return $this -> Repository -> Query( $Arguments[ 'builder' ] ?? [ ] ) ;
    }
}
