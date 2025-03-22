<?php namespace Modules\Atom\Database\Seeders; class DatabaseSeeder extends \Illuminate\Database\Seeder {
    public function run( ) : void {
        $this -> call(
            collect   ( \Nwidart\Modules\Facades\Module::getOrdered( ) )
            -> map    ( fn( $Seeder ) => $Seeder -> namespace( 'Database\\Seeders\\DatabaseSeeder' ) )
            -> filter ( fn( $Seeder ) => $Seeder !== static::class and class_exists( $Seeder ) )
            -> values ( )
            -> toArray( )
        ) ;
    }
}