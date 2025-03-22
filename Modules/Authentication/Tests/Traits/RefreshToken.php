<?php namespace Modules\Authentication\Tests\Traits;

trait RefreshToken{

    public function mutationRefreshToken ( ) : string {
        return "mutation( \$data : refreshTokenInput ! ) {
			authenticationRefreshToken ( data : \$data ) {
                provider
				$this->Token
				$this->user
				$this->Status
			}
		}";
    }

    public function RefreshToken( Array $Array = [ ] ){
        return $this -> GraphQLFiles( $this -> mutationRefreshToken( ) , [ 'data' => $Array ] );
    }

}