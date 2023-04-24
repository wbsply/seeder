<?php

namespace WebSupply\Seeder\Command;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use WebSupply\Seeder\SeederResolver;

final class SeederCommandController extends CommandController
{
    /**
     * @Flow\Inject
     * @var SeederResolver
     */
    protected $seederResolver;

    public function listCommand(string $package = null)
    {
        $seeders = $this->seederResolver->getSeeders();
        $this->output->outputTable(array_map(fn($name, $class) => [$name, $class], array_keys($seeders), $seeders), ['name', 'class']);
    }

    /**
     * ./flow seeder:run Dafis.Crm:Populate
     * @param string $seeder
     * @return void
     */
    public function run(string $seeder)
    {
        /**
         * 1. resolve seeder
         * 2. execute
         */
    }

    public function createCommand(string $package, string $name = null)
    {

    }
}
