<?php namespace Modules\Authentication\GraphQL\Mutations;

use Illuminate\Http\JsonResponse ;
use Illuminate\Http\Resources\Json\JsonResource ;

use Modules\Authentication\Models\Pincode as Model ;

class PinCode {

    use \Modules\Atom\GraphQL\Services\Result;

    public function Send( $_ , array $Arguments = [ ] ) : JsonResource {
        if ( $Arguments [ 'email' ] ?? false ) $Model = Model::toEmail( $Arguments[ 'email' ] ) -> getNewToken( ) ;
		return $this -> Successful( app( ) -> environment( ) === 'local' ? $Model -> refresh( ) -> makeVisible( 'token' ) -> toArray( ) : [ ] ) ;
    }

    public function Verify( $_ , array $Arguments = [ ] ) : JsonResource {
		$Pincode = Model::firstOrCreate([ 'unique' => $Arguments[ 'email' ] ?? 'test' ]) -> isValid( $Arguments[ 'code' ] ?? 'bad' );
		     if ( ! $Pincode -> pinCodeIsMatch  ) return $this -> Errors( 'pinCodeIsNotMatch.'  , [ 'code' => [ 'pinCodeIsNotMatch.'  ] ] , JsonResponse::HTTP_NOT_ACCEPTABLE ) ;
		else if ( ! $Pincode -> pinCodeIsActive	) return $this -> Errors( 'pinCodeIsNotActive.' , [ 'code' => [ 'pinCodeIsNotActive.' ] ] , JsonResponse::HTTP_NOT_ACCEPTABLE ) ;
		else if ( ! $Pincode -> pinCodeisValid  ) return $this -> Errors( 'pinCodeisNotValid.'  , [ 'code' => [ 'pinCodeisNotValid.'  ] ] , JsonResponse::HTTP_NOT_ACCEPTABLE ) ;
		else return $this -> Successful( app( ) -> environment( ) === 'local' ? $Pincode -> refresh( ) -> makeVisible( 'token' ) -> toArray( ) : [ ] ) ;
    }

}