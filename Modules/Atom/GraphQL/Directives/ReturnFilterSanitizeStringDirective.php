<?php namespace Modules\Atom\GraphQL\Directives;

use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ReturnFilterSanitizeStringDirective extends BaseDirective implements FieldMiddleware{

    public static function definition( ) : string {
        return 'ReturnFilterSanitizeString';
    }

    public function handleField( FieldValue $fieldValue ) : void{
        $fieldValue -> wrapResolver( fn ( callable $Resolver ) => function ( mixed $root, array $Arguments , GraphQLContext $context, ResolveInfo $resolveInfo ) use ( $Resolver ) { 
            return htmlspecialchars( $Resolver( $root , $Arguments , $context , $resolveInfo ) , ENT_NOQUOTES , 'utf-8' , false );
        } );
    }
}