<?php return new class extends \Modules\Atom\Database\Migration{
    Public function up( ) {
        $this -> schema -> { $this -> method }( $this -> modelName , function ( \Illuminate\Database\Schema\Blueprint $table ) {
            $table -> string      ( 'id'       ) -> primary  ( ) ;
            $table -> string      ( 'email'    ) -> nullable ( ) ;
            $table -> string      ( 'password' ) -> nullable ( ) ;
            $table -> json        ( 'data'     ) -> nullable ( ) ;
            $table -> boolean     ( 'active'   ) -> default  ( True ) ;
            $table -> softDeletes ( ) ;
            $table -> timestamps  ( ) ;
        } ) ;
    }
} ;