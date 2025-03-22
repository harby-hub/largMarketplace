<?php namespace Modules\Authentication\GraphQL\Queries;

use Illuminate\Http\Resources\Json\JsonResource;

class Authentication {
    
    use \Modules\Atom\GraphQL\Services\Result;

    public function __construct( public \Modules\Authentication\Services\Authentication $Authentication ) { }

    public function me( ) : JsonResource {
        return ( $Authentication = $this -> Authentication -> getAuthentication( true ) ) ? $this -> Successful( [
            'provider'       => $this -> Authentication -> getProviderEnum( $Authentication ) ,
            'authentication' => $Authentication ,
        ] ) : null ;
    }

}