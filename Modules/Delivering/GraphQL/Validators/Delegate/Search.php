<?php namespace Modules\Delivering\GraphQL\Validators\Delegate; class Search extends \Modules\Atom\GraphQL\Validators\Validator {
    public function rules( ) : Array { return
        $this -> SearchBaseRules( ) +
        $this -> ArrayOf ( 'name'  , $this -> Text ( ) ) +
        $this -> ArrayOf ( 'email' , $this -> Text ( ) )
    ; }
}