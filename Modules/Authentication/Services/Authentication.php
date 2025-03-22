<?php namespace Modules\Authentication\Services;

use Illuminate\Support\Facades\{Auth,App} ;
use Modules\Authentication\GraphQL\Exceptions\AuthenticationException;
use Modules\Authentication\Enums\AuthenticationProviders;

use Modules\Atom\Models\Model ;
use Modules\Authentication\Models\Authenticatable;
use Modules\Authentication\Models\{Staff,Client,Delegate};

use Symfony\Component\HttpFoundation\Request ;
use Modules\Authentication\Models\Passport\Client as PassportClient;

class Authentication {

    use \Modules\Atom\Services\SelfMaker ;

    public static function forgetGuards( ) : void {
        Auth::forgetGuards( ) ;
    }

    public function is( ?string $guard = null ) : bool {
        return Auth::guard( $guard ) -> check( ) ;
    }

    public function user( ?string $guard = null ) : Authenticatable {
        return Auth::guard( $guard ) -> user( ) ;
    }

    public function get_class( ) :? string {
        return is_null ( $Authentication = $this -> getAuthentication( ) ) ? null : get_class( $Authentication ) ;
    }

    public function getAuthenticationByGuard( string $guard = null , ? string $can = null  ) : Authenticatable|Model|null {
        return ( $this -> is( $guard ) && $this -> user( $guard ) -> tokenCan( $can ?? $guard ) ) ? $this -> user( $guard ) : null ;
    }

    public function  getAuthenticationByEmail( string $word , AuthenticationProviders $Authentication ) : ?Authenticatable {
        return ( new ( $Authentication -> value ) ) -> findForPassport( $word ) ;
    }

    public function  getProviderEnum( Authenticatable $Authenticatable ) : AuthenticationProviders {
        return AuthenticationProviders::tryby( class_basename( $Authenticatable ) ) ;
    }

    public function getAuthentication( bool $With = false ) : Authenticatable|Model|null {
        if ( $Authentication = $this -> getAuthenticationByGuard( 'Staff'    ) ) return $Authentication ;
        if ( $Authentication = $this -> getAuthenticationByGuard( 'Client'   ) ) return $Authentication ;
        if ( $Authentication = $this -> getAuthenticationByGuard( 'Delegate' ) ) return $Authentication ;
        else return $With ? $this -> throwAuthenticationException( ) : null ;
    }

    public function throwAuthenticationException( ) : AuthenticationException {
        throw new AuthenticationException ( 'Unauthenticated.' ) ;
    }

    public function RunRoute( ) : void {
        \Illuminate\Support\Facades\Route::prefix ( config( 'passport.path' , 'oauth' ) )
            -> middleware( [
                \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class, // Use tenancy initialization middleware of your choice
                \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
            ] )
            -> name      ( 'passport.' )
            -> namespace ( 'Laravel\Passport\Http\Controllers' )
            -> group     ( base_path( 'vendor/laravel/passport/routes/web.php' ) )
        ;
    }

    public function getTokenAndRefreshToken( string $username , string $password , AuthenticationProviders $provider ) {
        $this -> RunRoute( ) ;
        $PassportClient = PassportClient :: where  ( 'provider'    , $provider -> name ) -> first( );
        $requset        = Request        :: create ( url( ) -> tenant( 'passport.token' ) , 'post' , [
            'grant_type'    => 'password'                ,
            'password'      => $password                 ,
            'username'      => $username                 ,
            'scope'         => [ $provider -> name ]     ,
            'client_id'     => $PassportClient -> id     ,
            'client_secret' => $PassportClient -> secret ,
            'tenant' => tenant( ) -> id
        ] , [ ] , [ ] , [ 'HTTP_ACCEPT' => 'application/json' , ] ) ;
        return json_decode( App::handle( $requset ) -> content( ) , true );
    }

    public function getRefreshToken( string $refresh_token , AuthenticationProviders $provider ) {
        $this -> RunRoute( ) ;
        $PassportClient = PassportClient :: where  ( 'provider'    , $provider -> name ) -> first( );
        $requset        = Request        :: create ( url( ) -> tenant( 'passport.token' ) , 'POST' , [
			'grant_type'    => 'refresh_token' ,
			'refresh_token' => $refresh_token ,
            'scope'         => [ $provider -> name ] ,
            'client_id'     => $PassportClient -> id     ,
            'client_secret' => $PassportClient -> secret ,
        ] , [ ] , [ ] , [ 'HTTP_ACCEPT' => 'application/json' ] ) ;
        return json_decode( App::handle( $requset ) -> content( ) , true );
    }

}