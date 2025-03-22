<?php namespace Modules\Atom\GraphQL\Validators; class Validator extends \Nuwave\Lighthouse\Validation\Validator {
    use inputs ;
    public function rules ( ) : array { return [ ] ; }

    public function SearchBaseRules( ) : Array { return [
        ... $this -> ArrayOf    ( 'id' , $this -> Numeric ( ) ) ,
        ... $this -> DateFromTo ( 'created_at' ) ,
        ... $this -> AvailableAndActive ( ) ,
    ] ; }
}