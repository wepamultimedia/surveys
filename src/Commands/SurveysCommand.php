<?php

namespace Wepa\Surveys\Commands;

use Illuminate\Console\Command;

class SurveysCommand extends Command
{
    public $signature = 'surveys';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
