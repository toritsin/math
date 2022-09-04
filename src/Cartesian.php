<?php

declare(strict_types=1);

namespace Toritsin\Math;

use ArrayIterator;
use Iterator;

use function is_iterable;

class Cartesian implements Iterator
{
    /**
     * @var array<mixed, ArrayIterator>
     */
    private array $sets;
    private int $setsNumber;
    private int $key;
    private bool $valid;

    public function __construct(array $data)
    {
        $this->sets = [];

        foreach ($data as $key => $item) {
            $iterator = new ArrayIterator();
            if (is_iterable($item)) {
                foreach ($item as $value) {
                    $iterator->append($value);
                }
            } else {
                $iterator->append($item);
            }

            $this->sets[$key] = $iterator;
        }

        $this->setsNumber = \count($this->sets);
    }

    public function current(): array
    {
        $result = [];

        foreach ($this->sets as $key => $set) {
            $result[$key] = $set->current();
        }

        return $result;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function next(): void
    {
        $count = 0;
        foreach ($this->sets as $set) {
            $set->next();

            if (false !== $set->valid()) {
                break;
            }

            $set->rewind();

            ++$count;
            if ($count === $this->setsNumber) {
                $this->valid = false;

                break;
            }
        }

        ++$this->key;
    }

    public function rewind(): void
    {
        $this->valid = [] !== $this->sets;
        $this->key = 0;

        foreach ($this->sets as $set) {
            $set->rewind();
        }
    }

    public function valid(): bool
    {
        return $this->valid;
    }
}
