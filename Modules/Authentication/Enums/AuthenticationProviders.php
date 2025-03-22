<?php namespace Modules\Authentication\Enums;

#[ \GraphQL\Type\Definition\Description( description: 'All Authentication Providers in system you can Authenticat with them' ) ]
Enum AuthenticationProviders : String {
    use \Modules\Atom\Services\Enum ;

    #[ \GraphQL\Type\Definition\Description(description: 'Staff' ) ]
    case Staff = \Modules\Authentication\Models\Staff::class ;

    #[ \GraphQL\Type\Definition\Description(description: 'Client' ) ]
    case Client = \Modules\Authentication\Models\Client::class ;

    #[ \GraphQL\Type\Definition\Description(description: 'Shipping User' ) ]
    case Delegate = \Modules\Authentication\Models\Delegate::class ;

}
