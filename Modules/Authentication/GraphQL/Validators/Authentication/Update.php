<?php namespace Modules\Authentication\GraphQL\Validators\Authentication;
use Modules\Authentication\Services\Authentication;
class Update extends \Modules\Atom\Http\Requests\User\Update {
    public function authorize( ) {
        return Authentication::instance( ) -> is( ) ;
    }
    public function rules    ( ) {
        return $this -> Base_Rules( 'required' , [
            'password' => $this -> Password   ( [ 'nullable' ] ),
            'email'    => $this -> EmailUnique( ) ,
            'name'     => $this -> Text     ( [ $this -> Database( Authentication::instance( ) -> get_class( ) , 'unique' , 'name' , 'nullable' ) ] )  ,
        ] ) ;
    }
}