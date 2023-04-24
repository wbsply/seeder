<?php

namespace WebSupply\Seeder\Annotations;

use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

/**
 * @Annotation
 * @NamedArgumentConstructor
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class Seeder
{
    public function __construct(
        public readonly ?string $name = null
    ) {}
}
