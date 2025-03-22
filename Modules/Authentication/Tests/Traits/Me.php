<?php namespace Modules\Authentication\Tests\Traits;

trait Me{

    public function mutationMe ( ) : string {
        return "{ me{
            provider
            $this->user
            $this->Status
        } }";
    }

    public function Me( ){
        return $this -> GraphQLFiles( $this -> mutationMe( ) );
    }

}