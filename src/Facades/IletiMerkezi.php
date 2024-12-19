<?php

namespace IletiMerkezi\SMS\Facades;

use Illuminate\Support\Facades\Facade;

class IletiMerkezi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'IletiMerkezi';
    }
}