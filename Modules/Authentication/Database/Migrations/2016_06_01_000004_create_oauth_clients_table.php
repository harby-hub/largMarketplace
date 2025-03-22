<?php return new class extends \Modules\Atom\Database\Migration {
    public function setup( \Illuminate\Database\Schema\Blueprint $table ) : void {
        $table -> unsignedBigInteger ( 'user_id'                ) -> nullable ( ) -> index( ) ;
        $table -> string             ( 'name'                   )                             ;
        $table -> string             ( 'secret', 100            ) -> nullable ( )             ;
        $table -> string             ( 'provider'               ) -> nullable ( )             ;
        $table -> text               ( 'redirect'               )                             ;
        $table -> boolean            ( 'personal_access_client' )                             ;
        $table -> boolean            ( 'password_client'        )                             ;
        $table -> boolean            ( 'revoked'                )                             ;
    }
} ;