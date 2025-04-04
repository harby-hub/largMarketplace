<?php namespace Modules\Tenancy\Database\Seeders; class DatabaseSeeder extends \Illuminate\Database\Seeder {
    public function run( ) : void {
        collect( [ 'prod' , env( 'DATABASE_TEST' ) ]) -> each( fn( string $modules ) => \Modules\Tenancy\Models\Tenant::UpdateOrCreate( [ 'id' => $modules ] , [
            'email'    => $modules . '@' . config( 'app.domain' ) . '.com' ,
            'password' => \Illuminate\Support\Facades\Hash::make( $modules )
        ] ) -> domains( ) -> UpdateOrCreate( [ 'domain' => $modules . '.' . config( 'app.domain' ) ] ) );
    }
}