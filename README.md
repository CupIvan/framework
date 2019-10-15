# Небольшой PHP-фреймворк для сайтов

- быстрая разработка типовых кейсов
- автоматическая подгрузка нужных классов с github
- использование TDD подхода
- склейка CSS стилей

Для создания сайта достаточно скачать и подключить `autoload.php`:
```php
<?php
require_once 'autoload.php';

mysql::$user = 'myuser';
mysql::$pass = 'mypass';

request::post();

template::load();
```

# Лицензия

Фреймворк с открытым исходным кодом под [MIT лицензией](https://opensource.org/licenses/MIT).
