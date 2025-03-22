<?php return new class extends \Modules\Atom\Database\Migration {
    public function setup( \Illuminate\Database\Schema\Blueprint $table ) : void {
        $table -> morphs     ( 'tokenable' , 'a_p_a_t_t_t_t_i_i' )  ;
        $table -> string     ( 'name'             )                 ;
        $table -> string     ( 'token', 64        ) -> unique ( )   ;
        $table -> text       ( 'abilities'        ) -> nullable ( ) ;
        $table -> timestamp  ( 'last_used_at'     ) -> nullable ( ) ;
        $table -> string     ( 'fireBaseId' , 191 ) -> nullable ( ) ;
    }
} ;