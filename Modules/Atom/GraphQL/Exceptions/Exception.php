<?php namespace Modules\Atom\GraphQL\Exceptions;

use Illuminate\Support\MessageBag;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;

class Exception extends \Exception implements \GraphQL\Error\ClientAware, \GraphQL\Error\ProvidesExtensions {

    public function __construct(
        string                               $reason       = 'error.'                                ,
        public MessageBag|JsonResource|Array $Errors       = [ ]                                     ,
        public int                           $number       = JsonResponse::HTTP_UNPROCESSABLE_ENTITY ,
        public bool                          $isClientSafe = false                                   ,
        public bool                          $WithTrace    = false                                   ,
    ) {
        parent::__construct( $reason ) ;
    }

    public function isClientSafe( ) : bool {
        return $this -> isClientSafe ;
    }

    public function getExtensions( ) : array {
        return [
			'code'         => $this -> number       ,
			'errors'       => $this -> Errors       ,
			'isClientSafe' => $this -> isClientSafe ,
			'WithTrace'    => $this -> WithTrace    ,
        ] ;
    }

}