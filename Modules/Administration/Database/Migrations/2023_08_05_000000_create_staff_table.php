<?php return new class extends \Modules\Atom\Database\Migration {
    public function setup( $table ) : void {
        $table -> string ( 'name'     ) -> nullable( )              ;
        $table -> string ( 'email'    ) -> nullable( ) -> unique( ) ;
        $table -> string ( 'password' ) -> nullable( )              ;
    }
};