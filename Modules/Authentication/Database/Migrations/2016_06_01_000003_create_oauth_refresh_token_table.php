<?php return new class extends \Modules\Atom\Database\Migration {
    public function up( ) : void {
        $this -> schema -> { $this -> method }( $this -> modelName , function ( \Illuminate\Database\Schema\Blueprint $table ) {
            $table -> string   ( 'id'              , 100 ) -> primary  ( ) ;
            $table -> string   ( 'access_token_id' , 100 ) -> index    ( ) ;
            $table -> boolean  ( 'revoked'               )                 ;
            $table -> dateTime ( 'expires_at'            ) -> nullable ( ) ;
        } ) ;
    }
} ;