<?php namespace Modules\Authentication\Tests\Client;

use Modules\Authentication\Models\Client ;

class RefreshTokenTest extends \Modules\Authentication\Tests\TestCase {

	public function testRefreshTokenInvalid( ) {
        $provider    = class_basename ( Client::class ) ;
		$Client = Client::factory( ) -> create( );
        $response    = $this -> Login ( [ 'provider' => $provider , 'attempt' => [
			'email'    => $Client -> email ,
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
                'id'         => $Client -> id                                ,
                'email'      => $Client -> email                             ,
                'active'     => $Client -> active                            ,
                'updated_at' => $Client -> updated_at -> toDateTimeString( ) ,
                'created_at' => $Client -> created_at -> toDateTimeString( ) ,
            ] ] )
            -> AssertJsonStructureToken( 'authenticationRefreshToken' )
		;
	}
}
