<?php namespace Modules\Administration\GraphQL\Queries; class Staff extends \Modules\Atom\GraphQL\Queries\Query {
    public function __construct( ) {
        $this -> Repository = \Modules\Administration\Repositories\Staff::instance( ) ;
    }
}