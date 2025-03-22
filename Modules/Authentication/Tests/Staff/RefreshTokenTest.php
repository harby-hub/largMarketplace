<?php namespace Modules\Authentication\Tests\Staff;

use Modules\Authentication\Models\Staff ;

class RefreshTokenTest extends \Modules\Authentication\Tests\TestCase {

	public function testRefreshTokenInvalid( ) {
        $provider     = class_basename ( Staff::class ) ;
		$Staff = Staff::factory( ) -> create( );
        $response    = $this -> Login ( [ 'provider' => $provider , 'attempt' => [
			'email'    => $Staff -> email ,
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
                'id'         => $Staff -> id                                ,
                'email'      => $Staff -> email                             ,
                'active'     => $Staff -> active                            ,
                'updated_at' => $Staff -> updated_at -> toDateTimeString( ) ,
                'created_at' => $Staff -> created_at -> toDateTimeString( ) ,
            ] ] )
            -> AssertJsonStructureToken( 'authenticationRefreshToken' )
		;
	}
}
