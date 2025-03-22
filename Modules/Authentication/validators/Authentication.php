<?php namespace Modules\Authentication\validators;

use Illuminate\Support\Facades\Config;

class Authentication {

    public function IfEmailExists( $Email ) : bool {
        return ( bool ) collect ( Config::get( 'auth.providers' ) )
            -> pluck ( 'model' )
            -> filter( fn( $provider ) => is_subclass_of( $provider , \Illuminate\Contracts\Auth\Authenticatable::class ) )
            -> values( )
            -> map   ( fn( $provider ) => $provider::where( 'email' , $Email ) -> exists( ) )
            -> reduce( fn ( $carry , $item ) => $carry or $item )
        ;
    }

    public function EmailProvidersExists( string $attribute , $value , $parameters = [ ] ) : bool {
        return $this -> IfEmailExists( $value );
    }

    public function EmailProvidersUnique( string $attribute , $value , $parameters = [ ] ) : bool {
        return ! $this -> IfEmailExists( $value );
    }

}
