# Небольшой PHP-фреймворк для сайтов

- быстрая разработка типовых кейсов
- автоматическая подгрузка нужных классов с github
- использование TDD подхода
- склейка CSS стилей

# Установка

```bash
mkdir framework
cd framework
wget https://raw.githubusercontent.com/CupIvan/framework/master/framework/index.php
```

# Пример использования
```php
<?php
require_once './framework/index.php';
framework::$DEBUG = true;

db\mysql::$user = 'myuser';
db\mysql::$pass = 'mypass';

site::start();
```

# Лицензия

Фреймворк с открытым исходным кодом под [MIT лицензией](https://opensource.org/licenses/MIT).
