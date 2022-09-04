<?php

declare(strict_types=1);

namespace Toritsin\Math\Tests;

use PHPUnit\Framework\TestCase;
use Toritsin\Math\Cartesian;

/**
 * @internal
 */
final class CartesianTest extends TestCase
{
    public function testNonEmptyArray(): void
    {
        $data = [
            'age' => [20, 30],
            'name' => ['Bob', 'Alex', 'Mike'],
            'location' => 'NY',
        ];

        $expectedResult = [
            [
                'age' => 20,
                'name' => 'Bob',
                'location' => 'NY',
            ],
            [
                'age' => 30,
                'name' => 'Bob',
                'location' => 'NY',
            ],
            [
                'age' => 20,
                'name' => 'Alex',
                'location' => 'NY',
            ],
            [
                'age' => 30,
                'name' => 'Alex',
                'location' => 'NY',
            ],
            [
                'age' => 20,
                'name' => 'Mike',
                'location' => 'NY',
            ],
            [
                'age' => 30,
                'name' => 'Mike',
                'location' => 'NY',
            ],
        ];

        $cartesian = new Cartesian($data);

        $this->assertResultForForeach($cartesian, $expectedResult);

        $cartesian->rewind();

        $this->assertResultForWhile($cartesian, $expectedResult);
    }

    public function testEmptyArray(): void
    {
        $data = [];

        $cartesian = new Cartesian($data);

        $this->assertResultForForeach($cartesian, []);

        $cartesian->rewind();

        $this->assertResultForWhile($cartesian, []);

        static::assertSame(0, $cartesian->key());
    }

    private function assertResultForForeach(Cartesian $cartesian, array $expectedResult): void
    {
        $i = 0;
        foreach ($cartesian as $set) {
            static::assertSame($expectedResult[$i], $set);
            ++$i;
        }

        static::assertSame(\count($expectedResult), $i);
    }

    private function assertResultForWhile(Cartesian $cartesian, array $expectedResult): void
    {
        $i = 0;
        while ($cartesian->valid()) {
            $set = $cartesian->current();
            static::assertSame($expectedResult[$i], $set);
            static::assertSame($i, $cartesian->key());
            $cartesian->next();
            ++$i;
        }

        static::assertSame(\count($expectedResult), $i);
    }
}
