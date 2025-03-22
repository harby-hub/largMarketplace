<?php namespace Modules\Delivering\GraphQL\Queries; class Delegate extends \Modules\Atom\GraphQL\Queries\Query {
    public function __construct( ) {
        $this -> Repository = \Modules\Delivering\Repositories\Delegate::instance( ) ;
    }
}