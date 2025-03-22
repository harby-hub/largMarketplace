<?php namespace Modules\Atom\GraphQL\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag ;
use Illuminate\Http\JsonResponse ;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Atom\Models\Model;

trait Result {

    public function ok( ... $args ) : JsonResource {
        return $this -> Successful( [ ] , ... $args ) ;
    }

    public function Successful( JsonResource|Model|Array|String|Int|Bool|null $data = [ ] , string $message = 'Successful.' , bool $check = true , int $code = JsonResponse::HTTP_OK ) : JsonResource {
        return new JsonResource( [ 'status' => [
			'code'    => $code    ,
			'message' => $message ,
			'check'   => $check   ,
        ] ] + ( array ) $data ) ;
    }

    public function Errors ( string $message = 'error.' , MessageBag|JsonResource|Array $Errors = [ ] , int $code = JsonResponse::HTTP_UNPROCESSABLE_ENTITY , bool $isClientSafe = false , bool $WithTrace = true ) : void {
        throw new \Modules\Atom\GraphQL\Exceptions\Exception( $message , $Errors , $code , $isClientSafe , $WithTrace );
    }

    public function ErrorsWhen ( bool $condition , ... $Arguments ) : void {
        if ( $condition ) $this -> Errors( ... $Arguments ) ;
    }

}