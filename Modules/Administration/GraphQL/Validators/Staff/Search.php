<?php namespace Modules\Administration\GraphQL\Validators\Staff; class Search extends \Modules\Atom\GraphQL\Validators\Validator {
    public function rules( ) : Array { return
        $this -> SearchBaseRules( ) +
        $this -> ArrayOf ( 'name'  , $this -> Text ( ) ) +
        $this -> ArrayOf ( 'email' , $this -> Text ( ) )
    ; }
}