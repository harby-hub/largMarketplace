<?php namespace Modules\Authentication\Models\Passport;

class PersonalAccessToken extends \Laravel\Passport\Token {
    protected $table = 'oauth_access_tokens' ;

    protected static function boot( ) {
        parent::boot( ) ;
        static::creating( function ( $model ) {
            if ( empty( $model -> { $model -> getKeyName( ) } ) ) $model -> { $model -> getKeyName( ) } = \Illuminate\Support\Str::uuid( ) -> toString( ) ;
        });
    }

    public function setfirebase_id( string $firebase_id ) : self {
        $this -> firebase_id = $firebase_id;
        $this -> save( ) ;
        return $this -> refresh( ) ;
    }

}