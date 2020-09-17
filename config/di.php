<?php


use Shop\Components\DI\Container;

return static function (Container $container): void {
   $container->bind('dsn', 'mysql:host=localhost;dbname=shop;charset=utf8');
};
