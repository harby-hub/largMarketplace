<?php namespace Modules\Delivering\Providers; class ServiceProvider extends \Modules\Atom\Providers\BaseServiceProvider {
    public function boot( ) : void {
        $this -> registerConfig           ( ) ;
        $this -> registerGraphqlNameSpace ( ) ;
        $this -> registerMigrations       ( ) ;
        $this -> registerRelationMorphMap ( [
            'Delegate' ,
        ] );
    }
}