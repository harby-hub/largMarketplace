<?php namespace Modules\Tenancy\Database\Seeders; class DatabaseSeeder extends \Illuminate\Database\Seeder {
    public function run( ) : void {
        collect( [ 'prod' + env( 'DATABASE_TEST' ) ]) -> each( fn( string $modules ) => \Modules\Tenancy\Models\Tenant::firstOrCreate( [ 'id' => $modules ] , [
            'email'    => $modules ,
            'password' => \Illuminate\Support\Facades\Hash::make( $modules )
        ] ) -> domains( ) -> firstOrCreate( [ 'domain' => $modules . '.' . config( 'app.domain' ) ] ) );
    }
}