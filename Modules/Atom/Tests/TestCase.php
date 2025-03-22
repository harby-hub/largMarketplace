<?php namespace Modules\Atom\Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Testing\LoggedExceptionCollection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{DB};

use Illuminate\Http\UploadedFile;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication;
    use initializedSupports;
    use \Illuminate\Foundation\Testing\WithFaker;

    public function route( string $Route_Name , Array | int $Route_Parameters = [ ] ) : string {
        return \Illuminate\Support\Facades\URL::route( 'Api.' . $Route_Name , $Route_Parameters ) ;
    }

    public function actingAs( Authenticatable $Authentication , $guard = '' ) : self {
        $provider = class_basename( get_class( $Authentication ) ) ;
        \Laravel\Passport\Passport::actingAs( $Authentication , [ $provider ] , $provider );
        return $this ;
    }

    protected function createTestResponse( $response , $request ) {
        return tap( TestResponse::fromBaseResponse( $response , $request ) , function ( $response ) {
            $response -> withExceptions(
                $this -> app -> bound( LoggedExceptionCollection::class ) ? $this -> app -> make( LoggedExceptionCollection::class ) : new LoggedExceptionCollection
            ) ;
        } ) ;
    }

    public static function WithOutForeignKey( ? \Closure $Closure ) : void {
        \Illuminate\Support\Facades\Schema::withoutForeignKeyConstraints( $Closure ) ;
    }

    public static function QueryLog( ? \Closure $Closure ) : void {
        DB::enableQueryLog( );
        if( is_callable( $Closure ) ) $Closure( ) ;
        dd(
            DB::getQueryLog( )
        );
    }

    public function makeFile( ) : UploadedFile {
        return UploadedFile::fake( ) -> image( 'test.png' , 100 , 100 ) -> size( 100 ) ;
    }

    public function AssertFileuploudExists( string $path , string $type = 'public' ) : self {
        \Illuminate\Support\Facades\Storage::disk( $type ) -> assertExists( $path ) ;
        return $this ;
    }

	public function GraphQLFiles( string $query , array $variables = [ ] , array $Headers = [ 'Content-Type' => 'multipart/form-data' , 'Accept' => 'application/json' , 'X-Tenant' => 'tests' ] ) {
		foreach ( Arr::dot( $variables ) as $key => $variable ) if ( $variable instanceof UploadedFile ) {
			$map   [ str_replace( '.' , '_' , $key ) ] = [ "variables.$key" ] ;
            Arr::set( $variables , $key , null ) ;
			$files [ str_replace( '.' , '_' , $key ) ] = $variable ;
		} ;
        return $this -> call( 'POST' , url( ) -> tenant( 'graphql' , [ ] , $this -> DATABASE_TEST ) , [
			'operations' => json_encode( [
				'query'		=> $query ,
				'variables'	=> $variables
			] ),
			'map' => json_encode( $map ?? [ ] )
		], [ ] , $files ?? [ ] , $this -> transformHeadersToServerVars( $Headers ) ) ;
	}

    public $Status = 'status{
        code
        message
        check
    }';

}