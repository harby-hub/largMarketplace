<?php namespace Modules\Authentication\Tests\Traits;

trait Register{

    public function mutationRegister ( ) : string {
        return "mutation( \$data : registerInput ! ) {
			authenticationRegister ( data : \$data ) {
                provider
				$this->Token
				$this->user
				$this->Status
			}
		}";
    }

    public function Register( Array $Array = [ ] ){
        return $this -> GraphQLFiles( $this -> mutationRegister( ) , [ 'data' => $Array ] );
    }

}