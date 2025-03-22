<?php return new class extends \Modules\Atom\Database\Migration {
    public function setup( \Illuminate\Database\Schema\Blueprint $table ) : void {
        $table -> unsignedBigInteger ( 'user_id'    ) -> index    ( ) ;
        $table -> unsignedBigInteger ( 'client_id'  )                 ;
        $table -> text               ( 'scopes'     ) -> nullable ( ) ;
        $table -> boolean            ( 'revoked'    )                 ;
        $table -> dateTime           ( 'expires_at' ) -> nullable ( ) ;
    }

};