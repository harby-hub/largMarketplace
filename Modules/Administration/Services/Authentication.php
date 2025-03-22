<?php namespace Modules\Administration\Services; class Authentication extends \Modules\Authentication\Services\Authentication{
    public function getAuthentication( bool $With = false ) : \Modules\Authentication\Models\Staff|\Modules\Authentication\Models\Authenticatable|null {
        if ( $Authentication = $this -> getAuthenticationByGuard( 'Staff' ) ) return $Authentication ;
        else return $With ? $this -> throwAuthenticationException( ) : null ;
    }
}