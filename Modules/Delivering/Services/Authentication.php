<?php namespace Modules\Delivering\Services; class Authentication extends \Modules\Authentication\Services\Authentication {
    public function getAuthentication( bool $throw = false ) : \Modules\Authentication\Models\Delegate|\Modules\Authentication\Models\Authenticatable|null {
        if ( $Authentication = $this -> getAuthenticationByGuard( 'Delegate' ) ) return $Authentication ;
        else return $throw ? $this -> throwAuthenticationException( ) : null ;
    }
}