<?php namespace Modules\Delivering\Models; class Delegate extends \Modules\Atom\Models\BaseUser {
    public string $AuthenticationModel = \Modules\Authentication\Models\Delegate::class ;
}