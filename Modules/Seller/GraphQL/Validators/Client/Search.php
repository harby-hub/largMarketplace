<?php namespace Modules\Seller\GraphQL\Validators\Client; class Search extends \Modules\Atom\GraphQL\Validators\Validator {
    public function rules( ) : Array { return
        $this -> SearchBaseRules( ) +
        $this -> ArrayOf ( 'name'        , $this -> Text    ( ) ) +
        $this -> ArrayOf ( 'email'       , $this -> Text    ( ) )
    ; }
}