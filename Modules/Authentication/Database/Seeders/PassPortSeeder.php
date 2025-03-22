<?php namespace Modules\Authentication\Database\Seeders; class PassPortSeeder extends \Illuminate\Database\Seeder {
    public function run( ) : void {
        \Modules\Tenancy\Models\Tenant::all( ) -> runForEach( function ( ) {
            collect( [ 'Staff' , 'Client' , 'Delegate' ] ) -> map( function ( $name ) {
                $client = new \Laravel\Passport\ClientRepository( ) ;
                $client -> createPasswordGrantClient  ( null , 'Default password grant client'  , 'http://your.redirect.path' , $name ) ;
                $client -> createPersonalAccessClient ( null , 'Default personal access client' , 'http://your.redirect.path' , $name ) ;
            } ) ;
        });
    }
}
