<?php

declare(strict_types=1);

namespace Toritsin\Math;

use Iterator;

class PowerSet implements Iterator
{
    /**
     * @var array<int, mixed>
     */
    private array $data;
    private int $key;
    private bool $valid;

    /**
     * @var array<int, int>
     */
    private array $currentIndexes = [];
    private int $currentSize;
    private int $dataSize;

    /**
     * @param array $data
     */
    public function __construct(iterable $data)
    {
        $this->data = [];

        foreach ($data as $item) {
            $this->data[] = $item;
        }

        $this->dataSize = \count($this->data);
    }

    public function current(): array
    {
        $result = [];

        foreach ($this->currentIndexes as $index) {
            $result[] = $this->data[$index];
        }

        return $result;
    }

    public function next(): void
    {
        if ($this->currentSize === $this->dataSize) {
            $this->valid = false;

            return;
        }

        ++$this->key;

        $i = $this->currentSize - 1;

        $shift = 1;
        while ($i >= 0) {
            if (($this->currentIndexes[$i] + $shift) < $this->dataSize) {
                ++$this->currentIndexes[$i];

                if ($shift > 1) {
                    for ($k = $i + 1; $k < $this->currentSize; ++$k) {
                        $this->currentIndexes[$k] = $this->currentIndexes[$k - 1] + 1;
                    }
                }

                return;
            }

            ++$shift;
            --$i;
        }

        ++$this->currentSize;

        $this->currentIndexes = [];
        for ($j = 0; $j < $this->currentSize; ++$j) {
            $this->currentIndexes[$j] = $j;
        }
    }

    public function key(): int
    {
        return $this->key;
    }

    public function valid(): bool
    {
        return $this->valid;
    }

    public function rewind(): void
    {
        if ($this->dataSize > 0) {
            $this->currentSize = 1;
            $this->currentIndexes = [0];
            $this->valid = true;
        } else {
            $this->currentSize = 0;
            $this->currentIndexes = [];
            $this->valid = false;
        }

        $this->key = 0;
    }
}
