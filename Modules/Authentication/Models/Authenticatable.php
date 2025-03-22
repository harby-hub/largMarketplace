<?php namespace Modules\Authentication\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Modules\Atom\Models\BaseUser;
use Illuminate\Database\Eloquent\{Model,Builder};

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

Abstract class Authenticatable extends BaseUser implements AuthenticatableContract , AuthorizableContract , CanResetPasswordContract {

    use
        \Illuminate\Auth\Authenticatable                ,
        \Illuminate\Foundation\Auth\Access\Authorizable ,
        \Illuminate\Auth\Passwords\CanResetPassword     ,
        \Illuminate\Auth\MustVerifyEmail                ,
        \Laravel\Passport\HasApiTokens
    ;

    public string    $BaseModelClass ;
    public ?BaseUser $Model = null ;
    public function getModel( ) : BaseUser {
        if ( is_null( $this -> Model ) ) $this -> Model = $this -> BaseModelClass::find( $this -> id ) ;
        return $this -> Model ;
    }

    protected function newMorphMany(Builder $query, Model $parent, $type, $id, $localKey) {
        return parent::newMorphMany($query, new $this -> BaseModelClass , $type, $id, $localKey);
    }

    public function edit( array $attrs = [ ] ) : self {
        $this -> getModel( ) -> edit( $attrs ) ;
        return $this -> refresh( );
    }

    public function needpassword( ) : Attribute {
        return Attribute::get( fn( ) => is_null( $this -> attributes[ 'password' ] ) ) ;
    }

    public function findForPassport( $word ) :? self {
        return self :: where( 'email' , $word ) -> first( ) ;
    }

}