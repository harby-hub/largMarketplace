<?php namespace Modules\Tenancy\Jobs;

class CreatePassPortClient extends \Modules\Atom\Jobs\AbstractJob {

    public function __construct( public \Modules\Tenancy\Models\Tenant $Tenant ) { }

    public function handle( ) : void {
        collect( [ 'Staff' , 'Client' , 'Delegate' ] ) -> map( function ( $name ) {
            $client = new \Laravel\Passport\ClientRepository( ) ;
            $client -> createPasswordGrantClient ( null , 'Default password grant client'  , 'http://your.redirect.path' , $name ) ;
            $client -> createPersonalAccessClient( null , 'Default personal access client' , 'http://your.redirect.path' , $name ) ;
        } ) ;
    }

}