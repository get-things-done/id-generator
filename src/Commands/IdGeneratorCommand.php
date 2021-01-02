<?php

namespace GetThingsDone\IdGenerator\Commands;

use Illuminate\Console\Command;

class IdGeneratorCommand extends Command
{
    public $signature = 'id-generator';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
