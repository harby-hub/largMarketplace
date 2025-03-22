<?php namespace Modules\Authentication\Tests\Traits; trait Update {
    public function mutationUpdate ( ) : string {
        return "mutation( \$data : updateInput ! ) {
			authenticationUpdate ( data : \$data ) {
                provider
                $this->user
                $this->Status
            }
		}";
    }

    public function Update( Array $Array = [ ] ){
        return $this -> GraphQLFiles( $this -> mutationUpdate( ) , [ 'data' => $Array ] );
    }

}