<?php namespace Modules\Atom\Providers; class BroadcastServiceProvider extends \Illuminate\Support\ServiceProvider {
    public function boot( ) : void {
        \Illuminate\Support\Facades\Broadcast::routes( ) ;
        require base_path( 'Routes/channels.php' ) ;
    }
}
