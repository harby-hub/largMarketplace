<?php namespace Modules\Seller\GraphQL\Queries; class Client extends \Modules\Atom\GraphQL\Queries\Query {
    public function __construct( ) {
        $this -> Repository = \Modules\Seller\Repositories\Client::instance( ) ;
    }
}