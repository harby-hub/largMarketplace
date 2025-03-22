<?php namespace Modules\Atom\Tests;

use Modules\Tenancy\Models\Tenant ;

trait initializedSupports {

    public static $initializedSupports = false;
    public $useTenancyTest = false;
    public Tenant | null $DATABASE_TEST = null ;

    public function setUp( ) : void {
        parent::setUp( );
        if ( ! self::$initializedSupports ) {
            static :: bootTraits       ( ) ;
            $this  -> initializeTraits ( ) ;
            self::$initializedSupports = true;
        }
        if ( ! $this -> useTenancyTest ) {
            tenancy( ) -> initialize( $this -> DATABASE_TEST ??= Tenant::where( 'id' , env( 'DATABASE_TEST' ) ) -> first( ) ) ;
        }
    }

    /**
     * The Array of trait initializers that will be called on each new instance.
     *
     * @var Array
     */
    protected static $traitInitializers = [ ];

    /**
     * Boot all of the bootable traits .
     */
    public static function bootTraits( ) : void {
        $class = static::class;
        $booted = [ ];
        static::$traitInitializers[ $class ] = [ ];
        foreach ( class_uses_recursive( $class ) as $trait ) {
            $method = 'boot' . class_basename( $trait );
            if ( method_exists( $class , $method ) && ! in_array( $method , $booted ) ) {
                forward_static_call( [ $class , $method ] );
                $booted[ ] = $method;
            }
            if ( method_exists( $class , $method = 'initialize' . class_basename( $trait ) ) ) {
                static::$traitInitializers[ $class ][ ] = $method;
                static::$traitInitializers[ $class ] = array_unique( static::$traitInitializers[ $class ] );
            }
        }
    }

    /**
     * Initialize any initializable traits .
     */
    public function initializeTraits( ) : void {
        foreach ( static::$traitInitializers[ static::class ] as $method ) $this -> { $method } ( ) ;
    }

}