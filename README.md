# Ares

[![Latest Stable Version](https://poser.pugx.org/a-d-w-s/ares/v/stable)](https://packagist.org/packages/a-d-w-s/ares)
[![Total Downloads](https://poser.pugx.org/a-d-w-s/ares/downloads)](https://packagist.org/packages/a-d-w-s/ares)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)

Library for obtaining information about a company from the public register

## Installing using Composer

`composer require a-d-w-s/ares`

### Ares example

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use ADWS\Ares\ES;

$ares = new ES();

try {
    $data = $ares->fetch($ico);
} catch (\Exception $e) {
    echo "Invalid IČ";
}
```
