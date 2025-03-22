<?php namespace Modules\Administration\Models; class Staff extends \Modules\Atom\Models\BaseUser {
    public string $AuthenticationModel = \Modules\Authentication\Models\Staff::class ;
}