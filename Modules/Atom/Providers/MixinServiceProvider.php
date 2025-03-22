<?php namespace Modules\Atom\Providers ; class MixinServiceProvider extends BaseServiceProvider {

    public array $mixins = [
        \Nwidart\Modules\Module               :: class => \Modules\Atom\Mixins\Module       :: class ,
        \Illuminate\Database\Eloquent\Builder :: class => \Modules\Atom\Mixins\Builder      :: class ,
        \Illuminate\Database\Schema\Blueprint :: class => \Modules\Atom\Mixins\Blueprint    :: class ,
        \Illuminate\Routing\UrlGenerator      :: class => \Modules\Atom\Mixins\UrlGenerator :: class ,
    ] ;

    public function register( ) {
        foreach ( $this -> mixins as $marco => $mixin ) $marco::mixin( new $mixin );
    }

}