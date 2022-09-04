# Math
Math is a PHP library to work with sets in a efficient memory usage way.

## Usage

### Power sets

```php
 <?php

use Toritsin\Math\PowerSet;

$data = ['A', 'B', 'C'];

$powerSet = new PowerSet($data);

foreach ($powerSet as $set) {
    var_dump($set);
}
```

### Cartesian

```php
 <?php

use Toritsin\Math\Cartesian;

$data = [
    'age' => [20, 30],
    'name' => ['Bob', 'Alex', 'Mike'],
    'location' => 'NY',
];

$cartesian = new Cartesian($data);

foreach ($cartesian as $set) {
    var_dump($set);
}
```