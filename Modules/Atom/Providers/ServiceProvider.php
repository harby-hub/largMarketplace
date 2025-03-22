<?php namespace Modules\Atom\Providers; class ServiceProvider extends BaseServiceProvider {
    public function register( ) : void {
        $this -> app -> register( RouteServiceProvider :: class );
        $this -> app -> register( MixinServiceProvider :: class );
    }
    public function boot( ) : void {
        $this -> registerConfig           ( ) ;
        $this -> registerMigrations       ( ) ;
        $this -> registerTranslations     ( ) ;
        $this -> registerGraphqlNameSpace ( ) ;
        $this -> registerAliasLoader      ( [ 'Nuwave\\Lighthouse\\Pagination\\PaginateDirective' => 'Modules\\Atom\\GraphQL\\Replace\\PaginateDirective' ] ) ;
        \Illuminate\Support\Facades\Validator::resolver ( fn( $translator , $data , $rules , $message ) => new \Modules\Atom\Validation\Validator( $translator , $data , $rules , $message ) );
        $this -> app -> singleton         ( 'DatabaseSeeder' , \Modules\Atom\Database\Seeders\DatabaseSeeder :: class ) ;
        $this -> prependMiddlewares       ( [
            // \Modules\Atom\Http\Middleware\TrustHosts   :: class ,
            // \Modules\Atom\Http\Middleware\TrustProxies :: class ,
            \Modules\Atom\Http\Middleware\PreventRequestsDuringMaintenance :: class ,
            \Modules\Atom\Http\Middleware\TrimStrings                      :: class ,
            \Modules\Atom\Http\Middleware\Localization                     :: class ,
            \Modules\Atom\Http\Middleware\ForceJsonResponse                :: class ,
        ] );
    }
}