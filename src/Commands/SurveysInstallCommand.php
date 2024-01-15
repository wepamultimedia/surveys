<?php

namespace Wepa\Surveys\Commands;

use Illuminate\Console\Command;
use Wepa\Core\Models\Menu;

class SurveysInstallCommand extends Command
{
    public $description = 'Survey install command';

    public string $package = 'surveys';

    public $signature = 'surveys:install';

    public function handle(): int
    {
        Menu::loadPackageItems($this->package);

        return self::SUCCESS;
    }
}
