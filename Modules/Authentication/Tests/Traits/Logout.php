<?php namespace Modules\Authentication\Tests\Traits; trait Logout{

    public function mutationLogout ( ) : string {
        return "mutation{
			authenticationLogout{
				$this->Status
            }
		}";
    }

    public function Logout( ){
        return $this -> GraphQLFiles( $this -> mutationLogout( ) );
    }

}