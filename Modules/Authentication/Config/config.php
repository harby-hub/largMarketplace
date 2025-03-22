<?php return [
    'name' => 'Authentication',
    'Sub_defaults' => [
        'guard' => 'Client',
    ] ,
    'Sub_guards' => [
        'Client'   => [ 'driver' => 'passport' , 'provider' => 'Client'   ] ,
        'Staff'    => [ 'driver' => 'passport' , 'provider' => 'Staff'    ] ,
        'Delegate' => [ 'driver' => 'passport' , 'provider' => 'Delegate' ] ,
    ] ,
    'Sub_providers' => [
        'Client'   => [ 'driver' => 'eloquent' , 'model' => Modules\Authentication\Models\Client   :: class ] ,
        'Staff'    => [ 'driver' => 'eloquent' , 'model' => Modules\Authentication\Models\Staff    :: class ] ,
        'Delegate' => [ 'driver' => 'eloquent' , 'model' => Modules\Authentication\Models\Delegate :: class ] ,
    ] ,
    'tokensCan' => [
        'Client'   => Modules\Authentication\Models\Client   :: class ,
        'Staff'    => Modules\Authentication\Models\Staff    :: class ,
        'Delegate' => Modules\Authentication\Models\Delegate :: class ,
    ] ,
    'pincode' => [
        'tokens_expire_in'     => 30 , // in Minutes
        'length_pincode_token' => 8  ,
    ] ,
];
