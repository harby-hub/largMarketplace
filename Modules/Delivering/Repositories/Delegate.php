<?php namespace Modules\Delivering\Repositories;

use Illuminate\Database\Eloquent\Builder;

class Delegate extends \Modules\Atom\Services\Repository {

    public function BaseQuery ( ) : Builder {
        return \Modules\Delivering\Models\Delegate::query( ) ;
    }

    public function filters ( Builder $Query , Array $Array = [ ] ) : Builder {
        $this -> WhenArrayExists ( 'name'  , $Array , fn ( Array $items ) : Builder => $Query -> TranslationNames ( $items           ) ) ;
        $this -> WhenArrayExists ( 'email' , $Array , fn ( Array $items ) : Builder => $Query -> whereInStrs      ( 'email' , $items ) ) ;
        return parent::filters( $Query , $Array ) ;
    }

}