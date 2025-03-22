<?php namespace Modules\Seller\Database\Factories; class Client extends \Modules\Atom\Database\Factories\UserFactory {
    protected $model = \Modules\Seller\Models\Client::class;
    function definition( ) : array {
        return parent::definition( ) + [ ] ;
    }
}