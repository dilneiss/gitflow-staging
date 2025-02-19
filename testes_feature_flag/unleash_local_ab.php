<?php

require 'vendor/autoload.php';

use Unleash\Client\UnleashBuilder;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

// Criando um cache PSR-16 baseado em arquivos
$cache_dev = new Psr16Cache(new FilesystemAdapter('unleash_cache_dev', 3600, __DIR__ . "/cache"));
$cache_dev2 = new Psr16Cache(new FilesystemAdapter('unleash_cache_dev2', 3600, __DIR__ . "/cache"));
$cache_dev3 = new Psr16Cache(new FilesystemAdapter('unleash_cache_dev3', 3600, __DIR__ . "/cache"));

// 🔥 Dev
$unleashDev = UnleashBuilder::create()
    ->withAppName('Casa e Vídeo') //nome do cliente
    ->withAppUrl('http://localhost:4242/api/') //url do endpoint onde está hospedado
    ->withHeader('Authorization', 'default:development.cd639059d6e0e182bffc3860b514304c5a925632f333737b81879eda')
    ->withInstanceId('1')
    ->withCacheHandler($cache_dev)
    ->build();

d('Casa e video', $unleashDev->isEnabled('feature_ab'));

$unleashDev = UnleashBuilder::create()
    ->withAppName('Decathlon') //nome do cliente
    ->withAppUrl('http://localhost:4242/api/') //url do endpoint onde está hospedado
    ->withHeader('Authorization', 'default:development.cd639059d6e0e182bffc3860b514304c5a925632f333737b81879eda')
    ->withInstanceId('2')
    ->withCacheHandler($cache_dev2)
    ->build();

d('Decathlon', $unleashDev->isEnabled('feature_ab'));

$unleashDev = UnleashBuilder::create()
    ->withAppName('Fastshop') //nome do cliente
    ->withAppUrl('http://localhost:4242/api/') //url do endpoint onde está hospedado
    ->withHeader('Authorization', 'default:development.cd639059d6e0e182bffc3860b514304c5a925632f333737b81879eda')
    ->withInstanceId('3')
    ->withCacheHandler($cache_dev3)
    ->build();

d('Fastshop', $unleashDev->isEnabled('feature_ab'));