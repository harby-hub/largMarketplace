<?php namespace Modules\Authentication\Tests\Delegate;

use Modules\Authentication\Models\Delegate ;

class RefreshTokenTest extends \Modules\Authentication\Tests\TestCase {

	public function testRefreshTokenInvalid( ) {
        $provider     = class_basename ( Delegate::class ) ;
		$Delegate = Delegate::factory( ) -> create( );
        $response    = $this -> Login ( [ 'provider' => $provider , 'attempt' => [
			'email'    => $Delegate -> email ,
			'password' => 'password1A'
		] ] ) ;

        $this
			-> RefreshToken ( [
				'provider'      => $provider ,
				'refresh_token' => $response -> json( 'data.authenticationLogin.token.access_token' )  ,
			] )
			-> AssertErrors ( 'authenticationRefreshToken' , 'refresh token invalid.' , [ 'refresh_token' => [ 'invalid.' ] ] )
		;

        $this
			-> RefreshToken ( [
				'provider'      => $provider ,
				'refresh_token' => $response -> json( 'data.authenticationLogin.token.refresh_token' )  ,
			] )
            -> AssertOkData( 'authenticationRefreshToken' , [ 'provider' => $provider , 'authentication' => [
                'id'         => $Delegate -> id                                ,
                'email'      => $Delegate -> email                             ,
                'active'     => $Delegate -> active                            ,
                'updated_at' => $Delegate -> updated_at -> toDateTimeString( ) ,
                'created_at' => $Delegate -> created_at -> toDateTimeString( ) ,
            ] ] )
            -> AssertJsonStructureToken( 'authenticationRefreshToken' )
		;
	}
}
