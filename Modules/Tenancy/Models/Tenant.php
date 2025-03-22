<?php namespace Modules\Tenancy\Models;

class Tenant extends \Stancl\Tenancy\Database\Models\Tenant implements \Stancl\Tenancy\Contracts\TenantWithDatabase{

    use
        \Stancl\Tenancy\Database\Concerns\HasDatabase ,
        \Stancl\Tenancy\Database\Concerns\HasDomains
    ;

    public static function getCustomColumns( ) : array {
        return [
            'id'    ,
            'name'  ,
            'email' ,
            'password'
        ];
    }

    public function setPassworddAttribute( $value ) {
        return $this -> attributes[ 'password' ] = bcrypt( $value );
    }
}
