<?php namespace Modules\Seller\Models; class Client extends \Modules\Atom\Models\BaseUser {
    public string $AuthenticationModel = \Modules\Authentication\Models\Client::class ;
}