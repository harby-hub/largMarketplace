<?php namespace Modules\Atom\GraphQL\Directives;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgTransformerDirective;

class FilterSanitizeStringDirective extends BaseDirective implements ArgTransformerDirective {

    public static function definition( ) : string {
        return 'FilterSanitizeString' ;
    }

    /**
     * Remove whitespace from the beginning and end of a given input.
     *
     * @param  string  $argumentValue
     * @return string
     */
    public function transform( $argumentValue ) : string {
        return htmlspecialchars( $argumentValue , ENT_NOQUOTES , 'utf-8' , false ) ;
    } 
}