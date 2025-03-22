<?php return new class extends \Modules\Atom\Database\Migration{
    public function setup( $table ) : void {
        $table->string('domain', 255)->unique();
        $table->string('tenant_id');
        $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
    }
} ;