<?php namespace Modules\Authentication\Database\Seeders; class DatabaseSeeder extends \Illuminate\Database\Seeder {
    public function run( ) : void {
        $this -> call( [
            PassPortSeeder::class
        ] ) ;
    }
}