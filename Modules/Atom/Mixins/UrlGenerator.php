<?php namespace Modules\Atom\Mixins;

/**
 * @mixin \Illuminate\Routing\UrlGenerator
 */

class UrlGenerator {

    public function tenant( ) {
        return function( string $name = '' , array $parms = [ ] , \Modules\Tenancy\Models\Tenant | null $Tenant = null ) : string {
            return 'http://' . ( $Tenant ?? tenant( ) ) -> domains -> first( ) -> domain . route( $name , [ ] , false ) ;
        } ;
    }

}