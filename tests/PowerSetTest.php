<?php

declare(strict_types=1);

namespace Toritsin\Math\Tests;

use Generator;
use PHPUnit\Framework\TestCase;
use Toritsin\Math\PowerSet;

/**
 * @internal
 */
final class PowerSetTest extends TestCase
{
    public function testNonEmptyArray(): void
    {
        $data = ['A', 'B', 'C'];

        $expectedResult = [
            ['A'],
            ['B'],
            ['C'],
            ['A', 'B'],
            ['A', 'C'],
            ['B', 'C'],
            ['A', 'B', 'C'],
        ];

        $powerSet = new PowerSet($data);

        $this->assertResultForForeach($powerSet, $expectedResult);

        $powerSet->rewind();

        $this->assertResultForWhile($powerSet, $expectedResult);
    }

    public function testEmptyArray(): void
    {
        $data = [];

        $powerSet = new PowerSet($data);

        $this->assertResultForForeach($powerSet, []);

        $powerSet->rewind();

        $this->assertResultForWhile($powerSet, []);

        static::assertSame(0, $powerSet->key());
    }

    public function testFromGenerator(): void
    {
        $data = ['A', 'B', 'C', 'D'];

        $generator = static function () use ($data): Generator {
            foreach ($data as $item) {
                yield $item;
            }
        };

        $expectedResult = [
            ['A'],
            ['B'],
            ['C'],
            ['D'],
            ['A', 'B'],
            ['A', 'C'],
            ['A', 'D'],
            ['B', 'C'],
            ['B', 'D'],
            ['C', 'D'],
            ['A', 'B', 'C'],
            ['A', 'B', 'D'],
            ['A', 'C', 'D'],
            ['B', 'C', 'D'],
            ['A', 'B', 'C', 'D'],
        ];

        $powerSet = new PowerSet($generator());

        $this->assertResultForForeach($powerSet, $expectedResult);

        $powerSet->rewind();

        $this->assertResultForWhile($powerSet, $expectedResult);
    }

    private function assertResultForForeach(PowerSet $powerSet, array $expectedResult): void
    {
        $i = 0;
        foreach ($powerSet as $set) {
            static::assertSame($expectedResult[$i], $set);
            ++$i;
        }

        static::assertSame(\count($expectedResult), $i);
    }

    private function assertResultForWhile(PowerSet $powerSet, array $expectedResult): void
    {
        $i = 0;
        while ($powerSet->valid()) {
            $set = $powerSet->current();
            static::assertSame($expectedResult[$i], $set);
            static::assertSame($i, $powerSet->key());
            $powerSet->next();
            ++$i;
        }

        static::assertSame(\count($expectedResult), $i);
    }
}
