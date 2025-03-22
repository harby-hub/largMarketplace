<?php return new class extends \Modules\Atom\Database\Migration {
    public function up( ) : void {
        $this -> schema -> { $this -> method }( $this -> modelName , function ( \Illuminate\Database\Schema\Blueprint $table ) {
            $table -> string             ( 'id'      , 100    ) -> primary  ( )              ;
            $table -> unsignedBigInteger ( 'user_id'          ) -> nullable ( ) -> index ( ) ;
            $table -> unsignedBigInteger ( 'client_id'        )                              ;
            $table -> string             ( 'name'             ) -> nullable ( )              ;
            $table -> text               ( 'scopes'           ) -> nullable ( )              ;
            $table -> boolean            ( 'revoked'          ) -> nullable ( )              ;
            $table -> timestamps         (                    )                              ;
            $table -> dateTime           ( 'expires_at'       ) -> nullable ( )              ;
            $table -> string             ( 'fireBaseId' , 191 ) -> nullable ( )              ;
        } ) ;
    }
} ;