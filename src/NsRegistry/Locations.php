<?php

declare(strict_types=1);

namespace PhpCfdi\ResourcesSatXmlGenerator\NsRegistry;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<string>
 */
final class Locations implements IteratorAggregate
{
    /** @var string[] */
    private $locations;

    public function __construct(string ...$locations)
    {
        $this->locations = $locations;
    }

    public function append(string ...$locations): self
    {
        return new self(...array_merge($this->locations, $locations));
    }

    public function exclude(string ...$locationToExclude): self
    {
        $filtered = array_filter(
            $this->locations,
            function (string $current) use ($locationToExclude): bool {
                return ! in_array($current, $locationToExclude, true);
            }
        );
        return new self(...$filtered);
    }

    /** @return Traversable<string> */
    public function getIterator()
    {
        /* @phpstan-ignore-next-line */
        return new ArrayIterator($this->locations);
    }
}
