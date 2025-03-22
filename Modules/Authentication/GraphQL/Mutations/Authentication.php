<?php namespace Modules\Authentication\GraphQL\Mutations;

use Illuminate\Http\Resources\Json\JsonResource ;

class Authentication {

    use \Modules\Atom\GraphQL\Services\Result;

    public function __construct( public \Modules\Authentication\Services\Authentication $Authentication ) { }

    public function login( mixed $_ , array $Arguments ) : JsonResource {
        $Authentication = $this -> Authentication -> getAuthenticationByEmail( $Arguments[ 'attempt' ] [ 'email' ] , $Arguments[ 'provider' ] ) ;
        return ( is_null( $Authentication ) || \Illuminate\Support\Facades\Hash::check( $Arguments[ 'attempt' ] [ 'password' ] , $Authentication -> password ) === false ) ?
        $this -> Authentication -> throwAuthenticationException( ) :
        $this -> Successful( [
            'provider'       => $Arguments[ 'provider' ] ,
            'token'          => $this -> Authentication -> getTokenAndRefreshToken( $Arguments[ 'attempt' ] [ 'email' ] , $Arguments[ 'attempt' ] [ 'password' ] , $Arguments[ 'provider' ] ),
            'authentication' => $Authentication ,
        ] ) ;
    }

    public function logout( mixed $_ , array $Arguments ) : JsonResource {
        $this -> Authentication -> getAuthentication( true ) -> token( ) -> delete( ) ;
        return $this -> Successful( ) ;
    }

	public function refreshToken         ( mixed $_ , array $Arguments ) : JsonResource {
        $token = $this -> Authentication -> getRefreshToken( $Arguments[ 'refresh_token' ] , $Arguments [ 'provider' ] );
        $this -> ErrorsWhen( ! isset( $token[ 'access_token' ] ) , 'refresh token invalid.' , [ 'refresh_token' => [ 'invalid.' ] ] ) ;
        request( ) -> headers -> set( 'Authorization' , $token [ 'token_type' ] . ' ' . $token [ 'access_token' ] );
        return $this -> Successful( $Arguments + [
            'token'          => $token ,
            'authentication' => auth( $Arguments [ 'provider' ] -> name ) -> user( ) ,
        ] ) ;
	}

    public function register( mixed $_ , array $Arguments ) : JsonResource {
        if( ! ( $PinCodeCall = ( new PinCode ) -> Verify( $_ , $Arguments [ 'verifyPinCodeInput' ] ) ) [ 'status' ] [ 'check' ] ) return $PinCodeCall ;
        $user = [
            'password' => $Arguments [ 'userInputs'         ] [ 'password' ] ,
            'email'    => $Arguments [ 'verifyPinCodeInput' ] [ 'email'    ] ?? null ,
            'active'   => false
        ] ;
        ( $Arguments [ 'provider' ] -> value )::create( $user ) ;
        return $this -> login( null , [
            'provider' => $Arguments [ 'provider' ] ,
            'attempt' => [
                'password' => $Arguments [ 'userInputs'         ] [ 'password' ] ,
                'email'    => $Arguments [ 'verifyPinCodeInput' ] [ 'email'    ]
            ]
        ] ) ;
    }

    public function resetPassword( mixed $_ , array $Arguments ) : JsonResource {
        $Authentication = $this -> Authentication -> getAuthenticationByEmail( $Arguments[ 'verifyPinCodeInput' ] [ 'email' ] , $Arguments[ 'provider' ] ) ;
        if ( is_null( $Authentication ) ) return $this -> Authentication -> throwAuthenticationException( ) ;
        if( ! ( $PinCodeCall = ( new PinCode ) -> Verify( $_ , $Arguments [ 'verifyPinCodeInput' ] ) ) [ 'status' ] [ 'check' ] ) return $PinCodeCall ;
        $Authentication -> edit( [ 'password' => $Arguments [ 'password' ] ] ) ;
        return $this -> Successful( ) ;
    }

    public function update( mixed $_ , array $Arguments ) : JsonResource {
        return $this -> Successful([
            'authentication' => $authentication = $this -> Authentication -> getAuthentication( true ) -> edit( $Arguments ) ,
            'provider'       => $this -> Authentication -> getProviderEnum( $authentication ) ,
        ]) ;
    }

}
