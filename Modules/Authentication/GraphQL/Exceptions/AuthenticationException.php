<?php namespace Modules\Authentication\GraphQL\Exceptions; class AuthenticationException extends \Exception implements \GraphQL\Error\ClientAware, \GraphQL\Error\ProvidesExtensions {
    public function __construct( string $message = 'Unauthenticated.' ) {
        parent::__construct( $message ) ;
    }
    public function isClientSafe( ) : bool {
        return false ;
    }
    public function getExtensions( ) : array {
        return [ 'validation' => [ 'Authentication' => [ 'Unauthenticated' ] ] ] ;
    }
}