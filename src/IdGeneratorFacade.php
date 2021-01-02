<?php

namespace GetThingsDone\IdGenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \GetThingsDone\IdGenerator\IdGenerator
 */
class IdGeneratorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'id-generator';
    }
}
