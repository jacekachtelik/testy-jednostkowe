# Testy jednostkowe

Niniejsze przykłady obejmują konfigurację oraz uruchomienie testów jednostkowych w językach:
- PHP (w wersji 8.3)
- Python w wersji 3

w systemie operacyjnym Ubuntu 24.04

## PHP

Aby uruchomic testy jednostkowe w języku PHP nalezy mieć zainstalowane następujące komponenty:
- interpreter języka PHP
- composer
- PHPUnit

### Krok 1. Instalacja PHP i niezbędnych rozszerzeń

```bash
sudo apt install php php-cli php-mbstring php-json php-xml php-pcov php-xdebug unzip -y
```

### Krok 2. Instalacja Composer-a

1. **Pobieranie instalatora Composer-a**

    ```bash
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ```
2. **Weryfikacja instalatora**: Aby upewnić się, że plik instalacyjny nie został zmodyfikowany, nalezy sprawdzić  sumę SHA-384. Można znaleźć najnowszą sumę na stronie [Composer](https://getcomposer.org/download/):
   ```bash
    HASH="$(curl -sS https://composer.github.io/installer.sig)"
    php -r "if (hash_file('sha384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
   ```
3. **Uruchomienie instalatora**: Po weryfikacji należy uruchomić plik instalatora:
   ```bash
    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
   ```
4. **Usunięcie pliku instalatora**: Po zakończeniu instalacji należy usunąć plik instalacyjny:
   ```bash
    php -r "unlink('composer-setup.php');"
   ```
5. **Weryfikacja instalacji**: Można upewnić się, że Composer został prawidłowo zainstalowany sprawdzając jego wersję:
   ```bash
    composer --version
   ```
### Krok 3. Instalacja PHPUnit

#### Instalacja globalna

Po instalacji Composer-a należy zainstalować globalnie poleceniem:

```bash
composer global require phpunit/phpunit
```

Następnie należy dodać ścieżkę Composer do zmiennej środowiskowej PATH:

```bash
export PATH="$HOME/.composer/vendor/bin:$PATH"
```
Po instalacji można zweryfikować instalację poleceniem:

```bash
phpunit --version
```

W przypadku instalacji globalnej PHPUnit-a po wykonaniu polecenia w katalogu głownym projektu należy utworzyć plik ```composer.json```:

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "src"
        }
    }
}
```

Ostatnim etapem jest wykonanie polecenia:

```bash
composer dump-autoload 
```

#### Instalacja dla projektu:

W katalogu głównym projektu należy uruchomić polecenie

```bash
composer require --dev phpunit/phpunit ^11
```

Następnie zweryfikować instalację poleceniem:

```bash
./vendor/bin/phpunit --version
```

Następnie należy utworzyć plik ```composer.json``` o przykładowej strukturze:

```json
{
    "autoload": {
        "classmap": [
            "src/"
        ]
    },
    "require-dev": {
        "phpunit/phpunit": "^11"
    }
}
```
Ostatnim etapem jest wykonanie polecenia:

```bash
composer dump-autoload 
```

### Krok 4. Przygotowanie projektu

Po instalacji należy utworzyć swoją aplikację o strukturze np.:

```
project/
|-- src/
|   |-- MyClass.php
|
|-- tests /
|   |-- MyClassTest.php
|-- vendor/
|-- composer.json
|-- composer.lock
|-- phpunit.xml
```

Plik ```phpunit.xml``` jest kluczowy do uruchomienia testów. Powinien dla powyższego mieć następującą strukturę:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="vendor/autoload.php"
         colors="true">
    <testsuites>
        <testsuite name="Application Test Suite">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

Następnie należy przygotować kod klasy ```src/MyClass.php```:

```php
<?php

namespace App;

class MyClass
{

    public function add($a, $b)
    {

        return $a + $b;
    }
}

```

oraz klasy testowej:

```php

<?php

use PHPUnit\Framework\TestCase;
use App\MyClass;

class MyClassTest extends TestCase
{

    public function testAddition()
    {

        $myClass = new MyClass();
        $this->assertEquals(4, $myClass->add(2, 2));
    }
}

```

### Krok 5. Uruchomienie testów:

Będąc w katalogu głównym projektu:

#### Uruchomienie z globalnie zainstalowanego PHPUnit-a

Należy wykonać polecenie:

```bash
phpunit --configuration phpunit.xml --testdox
```

#### Uruchomienie z lokalnie zainstalowanego PHPUnit-a

```bash
/vendor/bin/phpunit --testdox tests
```

## Python

### Krok 1. Weryfikacja instalacji 
Aby uruchomić testy jednostkowe w pythonie należy zainstalować pythona.
Można sprawdzić wersję zainstalowanego Pythona komendą 

```bash
python --version
```
### Krok 2. Tworzenie katalogu projektu

Nalezy utworzyć katalog dla nowego projektu:

```bash
mkdir my_project
cd my_project
```

### Krok 3. Utworzenie struktury projektu

Należy utworzyć strukturę plików dla aplikacji i testów:

```
my_project/
|-- src/
|   |-- my_module.py
|
|-- tests /
    |-- my_test_module.y

```

### Krok 4. Kod aplikacji

W pliku ```src/my_module.py``` należy umieścić kod swojej aplikacji. Na przykład:

```python
def add(a, b):
    return a + b
```

### Krok 5. Kod testowy

W pliku ```src/my_module.py``` należy umieścić kod testowy:

```python
import unittest
from src.my_module import add


class TestMyModule(unittest.TestCase):

    def test_add(self):
        self.assertEqual(add(2, 3), 5)
```

### Krok 6. Uruchomienie testu

Uruchomienie testu należy wykonać poleceniem:

```bash

python3 -m unittest discover tests
```

Wynik wykonania testu:

```
.
----------------------------------------------------------------------
Ran 1 test in 0.000s

OK
```