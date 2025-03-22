<?php namespace Modules\Authentication\Tests\Traits; trait ResetPassword{

    public function mutationResetPassword ( ) : string {
        return "mutation( \$data : resetPasswordInput ! ) {
			authenticationResetPassword ( data : \$data ) {
				$this->Status
            }
		}";
    }

    public function ResetPassword( Array $Array = [ ] ){
        return $this -> GraphQLFiles( $this -> mutationResetPassword( ) , [ 'data' => $Array ] );
    }

}