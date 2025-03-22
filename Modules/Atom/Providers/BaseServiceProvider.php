<?php namespace Modules\Atom\Providers;

use Nwidart\Modules\Module;

use Illuminate\Support\{Collection,Str,Arr};
use Illuminate\Support\Facades\{Config,Validator};

Abstract class BaseServiceProvider extends \Illuminate\Support\ServiceProvider {

    public function getModuleName( ) : string {
        return Str::of( Str::afterLast( static::class , 'Modules' ) ) -> match('/\w+/') -> toString( ) ;
        return Module::byClassName( static::class ) ;
    }

    public function getModuleNamelower( ) : string {
        return strtolower( $this -> getModuleName( ) ) ;
    }

    public function registerConfig( ) : void {
        $path = module_path( $this -> getModuleNamelower( ) , 'Config/config.php' ) ;
        $this -> mergeConfigFrom( $path , $this -> getModuleNamelower( ) );
        $this -> publishes      ( [ $path => config_path( $this -> getModuleNamelower( ) . '.php' ) , ] , 'config' );
    }

    public function registerTranslations( ) : void {
        $this -> loadTranslationsFrom( module_path( $this -> getModuleName( ) , 'lang' ) , $this -> getModuleName( ) );
    }

    public function prependMiddlewares( Array | String $Middlewares = [ ] ) : void {
        tap( app( \Illuminate\Contracts\Http\Kernel::class ) , function ( $Kernel ) use ( $Middlewares ) {
            Collection::wrap( Arr::wrap( $Middlewares ) ) -> map( fn( String $Middleware ) => $Kernel -> prependMiddleware( $Middleware ) ) ;
        } ) ;
    }

    public function prependToMiddlewarePrioritys( Array | String $Middlewares = [ ] ) : void {
        tap( app( \Illuminate\Contracts\Http\Kernel::class ) , function ( $Kernel ) use ( $Middlewares ) {
            Collection::wrap( Arr::wrap( $Middlewares ) ) -> map( fn( String $Middleware ) => $Kernel -> prependToMiddlewarePriority( $Middleware ) ) ;
        } ) ;
    }

    public function registerMigrations( ) : void {
        if( $this -> getModuleName( ) === 'Tenancy' ) $this -> loadMigrationsFrom ( module_path( $this -> getModuleName( ) , 'Database/Migrations' ) );
        else Config::set( 'tenancy.migration_parameters.--path' , array_merge( Config( 'tenancy.migration_parameters.--path' ) , [ module_path( $this -> getModuleName( ) , 'Database/Migrations' ) ] ) ) ;
    }

    public function registerAliasMiddleware( Array $Array = [ ] ) : void {
        Collection::wrap( $Array ) -> map( fn( $Middleware , $alias ) => $this -> app -> router -> aliasMiddleware( $alias , $Middleware ) );
    }

    public function registerAliasLoader( Array $Array = [ ] ) : void {
        Collection::wrap( $Array ) -> map( fn( $Serves , $alias ) => \Illuminate\Foundation\AliasLoader::getInstance( ) -> alias( $alias , $Serves ) );
    }

    public function registerValidatorExtend( Array $Array = [ ] ) : void {
        Collection::wrap( $Array ) -> map( fn( $Provider , $Role ) => Validator::extend( $Role , $Provider . '@' . $Role ) );
    }

    public function registerViews( ) : void {
        $sourcePath = module_path( $this -> getModuleName( ) , 'views' );
        $this -> publishes( [ $sourcePath => resource_path( 'views/modules/' . $this -> getModuleName( ) ) ] , [ 'views' , $this -> getModuleName( ) . '-module-views' ] ) ;
        $this -> loadViewsFrom( array_merge( $this -> getPublishableViewPaths( ) , [ $sourcePath ] ) , $this -> getModuleName( ) ) ;
    }


    private function getPublishableViewPaths( array $paths = [ ] ) : array {
        foreach ( Config::get( 'view.paths' , [ ] ) as $path ) if ( is_dir( $path . '/modules/' . $this -> getModuleName( ) ) ) $paths[ ] = $path . '/modules/' . $this -> getModuleName( ) ;
        return $paths;
    }

    public function registerGraphqlNameSpace( ) : void {
        Config::set( 'lighthouse.namespaces.models' , array_merge( Config::get( 'lighthouse.namespaces.models' ) , [ "Modules\\{$this -> getModuleName( )}\Models" ] ) ) ;
        foreach( [ 'Queries' , 'Builders' , 'Mutations' , 'Subscriptions' , 'Types' , 'Interfaces' , 'Unions' , 'Scalars' , 'Directives' , 'Validators' ] as $type ) Config::set( 'lighthouse.namespaces.' . strtolower( $type ) , array_merge(
            Config::get( 'lighthouse.namespaces.' . strtolower( $type ) , [ ] ) ,
            [ "Modules\\{$this -> getModuleName( )}\GraphQL\\" . $type ] ,
        ) ) ;
    }

    public function registerLighthouseSchema( Array $Array = [ ] ) : void {
        Collection::wrap( $Array ) -> map( fn( $item ) => app( \Nuwave\Lighthouse\Schema\TypeRegistry::class ) -> register( $item ) );
    }

    public function registerRelationMorphMap( Array $Array = [ ] ) : void {
        Collection::wrap( $Array ) -> map( fn( $Model ) => \Illuminate\Database\Eloquent\Relations\Relation::morphMap( [
            "App\\Models\\$Model" => "Modules\\{$this -> getModuleName( )}\\Models\\$Model"
        ] ) );
    }

}