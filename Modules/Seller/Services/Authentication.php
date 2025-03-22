<?php namespace Modules\Seller\Services; class Authentication extends \Modules\Authentication\Services\Authentication{
    public function getAuthentication( bool $With = false ) : \Modules\Authentication\Models\Client|\Modules\Authentication\Models\Authenticatable|null {
        if ( $Authentication = $this -> getAuthenticationByGuard( 'Client' ) ) return $Authentication ;
        else return $With ? $this -> throwAuthenticationException( ) : null ;
    }
}