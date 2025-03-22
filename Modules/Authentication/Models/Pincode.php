<?php namespace Modules\Authentication\Models;

use Modules\Atom\Models\Model;
use Illuminate\Support\Facades\{Mail,Config,App};
use Modules\Authentication\Mail\SendPincodeMail;

class Pincode Extends Model {

    protected     $primaryKey   = 'unique' ;
    public        $incrementing = false    ;
    public string $email        = ''       ;
    public string $provider     = ''       ;
    public string $pincode      = ''       ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $hidden = [ 'token' ] ;

    protected $casts = [
        'token' => 'encrypted' ,
    ] ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'unique'     ,
        'token'      ,
        'created_at' ,
        'updated_at' ,
    ];

    public function getNewToken( ) : self {

        // $pincode = \Str::random( Config::get( 'authentication.pincode.length_pincode_token' ) ) ;
        $pincode = ( string ) rand( pow( 10 , Config::get( 'authentication.pincode.length_pincode_token' ) - 1 ) , pow( 10 , Config::get( 'authentication.pincode.length_pincode_token' ) ) - 1 );

        $this -> sendPinCode( );

        $this -> token = $pincode ;
        $this -> save( );

        return $this ;

    }

    public static function toEmail( string $email ) : self {

        $pincode = Pincode::firstOrCreate([ 'unique' => $email ] ) ;

        $pincode -> email    = $email  ;
        $pincode -> provider = 'email' ;

        return $pincode ;

    }

    public function sendPinCode( ) : void {
        if( App::environment( ) !== 'local' ) switch ( $this -> provider ) {
            case 'email':
                Mail::send( new SendPincodeMail( $this ) );
            break;
        }
    }

    public function IsActive( ) : bool {
        return $this -> updated_at -> addMinutes( Config::get( 'authentication.pincode.tokens_expire_in' ) ) > now( );
    }

    public function IsMatch( string $pinCode = '' ) : bool {
        return $this -> token && $pinCode == $this -> token ;
    }

    public function isValid( string $pinCode = '' ) : self {
        $this -> pinCodeIsMatch  = $this -> IsMatch  ( $pinCode ) ;
        $this -> pinCodeIsActive = $this -> IsActive (          ) ;
        $this -> pinCodeisValid  = $this -> pinCodeIsMatch && $this -> pinCodeIsActive ;
        return $this ;
    }

}