<?php namespace Modules\Authentication\Providers;

use Laravel\Passport\Passport;

use Illuminate\Support\Facades\Config;

use Modules\Authentication\validators\Authentication as validator;

class ServiceProvider extends \Modules\Atom\Providers\BaseServiceProvider {

    /**
     * Boot the application events.
     */
    public function boot ( ) : void {
        $this -> registerTranslations    ( );
        $this -> registerConfig          ( );
        $this -> registerViews           ( );
        $this -> registerPassport        ( );
        $this -> registerMigrations      ( );
        $this -> registerGraphqlNameSpace( );
        $this -> registerAliasMiddleware ( [
            'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth :: class ,
            'can'              => \Illuminate\Auth\Middleware\Authorize                 :: class ,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword           :: class ,
            'verified'         => \Illuminate\Auth\Middleware\EnsureEmailIsVerified     :: class ,
            'scopes'           => \Laravel\Passport\Http\Middleware\CheckScopes         :: class ,
            'scope'            => \Laravel\Passport\Http\Middleware\CheckForAnyScope    :: class ,
        ] ) ;
        $this -> registerValidatorExtend ( [
            'EmailProvidersExists' => validator :: class ,
            'EmailProvidersUnique' => validator :: class ,
        ] ) ;
        $this -> registerLighthouseSchema ( [
            new \GraphQL\Type\Definition\PhpEnumType( \Modules\Authentication\Enums\AuthenticationProviders::class )
        ] ) ;
    }

    /**
     * Register config.
     */
    public function registerConfig( ) : void {
        parent::registerConfig( ) ;
        Config::set( 'auth.defaults.guard' , Config::get( $this -> getModuleNamelower( ) . '.Sub_defaults.guard' ) );
        collect( Config::get( $this -> getModuleNamelower( ) . '.Sub_guards'    ) ) -> map( fn( array $value , String | int $key ) => Config::set( 'auth.guards.'    . $key , $value ) );
        collect( Config::get( $this -> getModuleNamelower( ) . '.Sub_providers' ) ) -> map( fn( array $value , String | int $key ) => Config::set( 'auth.providers.' . $key , $value ) );
    }

    public function registerPassport( ) : void {
        Passport::enablePasswordGrant( ) ;
        Passport::tokensExpireIn( now( ) -> addDays ( 15 ) ) ;
        Passport::refreshTokensExpireIn( now( ) -> addDays ( 30 ) ) ;
        Passport::personalAccessTokensExpireIn( now( ) -> addMonths( 6 ) ) ;
        Passport::useTokenModel( \Modules\Authentication\Models\Passport\PersonalAccessToken::class ) ;
        Passport::useClientModel( \Modules\Authentication\Models\Passport\Client::class ) ;
        Passport::useAuthCodeModel( \Modules\Authentication\Models\Passport\AuthCode::class ) ;
        Passport::useRefreshTokenModel( \Modules\Authentication\Models\Passport\RefreshToken::class ) ;
        Passport::tokensCan( Config::get( $this -> getModuleNamelower( ) . '.tokensCan' ) ) ;
        Passport::ignoreRoutes( );
        Passport::loadKeysFrom( storage_path( ) , __DIR__ . '/../../../storage' ) ;
    }

}