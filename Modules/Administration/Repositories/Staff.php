<?php namespace Modules\Administration\Repositories;

use Illuminate\Database\Eloquent\Builder;

class Staff extends \Modules\Atom\Services\Repository {

    public function BaseQuery ( ) : Builder {
        return \Modules\Administration\Models\Staff::query( ) ;
    }

    public function filters ( Builder $Query , Array $Array = [ ] ) : Builder {
        $this -> WhenArrayExists ( 'name'  , $Array , fn ( Array $items ) : Builder => $Query -> TranslationNames ( $items           ) ) ;
        $this -> WhenArrayExists ( 'email' , $Array , fn ( Array $items ) : Builder => $Query -> whereInStrs      ( 'email' , $items ) ) ;
        return parent::filters( $Query , $Array ) ;
    }

}