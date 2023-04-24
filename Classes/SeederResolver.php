<?php

namespace WebSupply\Seeder;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\ObjectManagement\ObjectManagerInterface;
use Neos\Flow\Reflection\ReflectionService;
use WebSupply\Seeder\Annotations\Seeder;

final class SeederResolver
{

    protected array $seeders = [];

    /**
     * @Flow\Inject
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    public function initializeObject()
    {
        $this->seeders = SeederResolver::resolveAnnotatedSeeders($this->objectManager);
    }

    public function getSeeders(): array
    {
        return $this->seeders;
    }

    /**
     * @param ObjectManagerInterface $objectManager
     * @Flow\CompileStatic
     * @return array
     * @throws \DomainException if a seeder with same name exists
     */
    protected static function resolveAnnotatedSeeders(ObjectManagerInterface $objectManager): array
    {
        $seeders = [];
        $reflectionService = $objectManager->get(ReflectionService::class);
        $annotatedClasses = $reflectionService->getClassNamesByAnnotation(Seeder::class);
        foreach ($annotatedClasses as $annotatedClass) {
            /** @var Seeder $annotation */
            $annotation = $reflectionService->getClassAnnotation($annotatedClass, Seeder::class);

            $name = $annotation->name ?? (new \ReflectionClass($annotatedClass))->getShortName();
            if (array_key_exists($name, $seeders)) {
                throw new \DomainException(sprintf('A seeder with name "%s" is already registered with class "%s"', $name, $seeders[$name]));
            }
            $seeders[$name] = $annotatedClass;
        }

        return $seeders;
    }
}
