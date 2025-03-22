<?php return new class extends \Modules\Atom\Database\Migration {
    public function setup( \Illuminate\Database\Schema\Blueprint $table ) : void {
        $table -> unsignedBigInteger ( 'client_id' ) ;
    }
} ;