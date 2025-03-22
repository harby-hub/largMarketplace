<?php namespace Modules\Authentication\Tests\Traits;

trait Login{

    public function mutationlogin ( ) : string {
        return "mutation( \$data : loginInput ! ) {
			authenticationLogin ( data : \$data ) {
                provider
				$this->Token
				$this->user
				$this->Status
			}
		}";
    }

    public function Login( Array $Array = [ ] ){
        return $this -> GraphQLFiles( $this -> mutationlogin( ) , [ 'data' => $Array ] );
    }
}