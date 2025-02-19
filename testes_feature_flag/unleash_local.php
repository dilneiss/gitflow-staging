<?php

require 'vendor/autoload.php';

use Unleash\Client\UnleashBuilder;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

// Criando um cache PSR-16 baseado em arquivos
$cache_dev = new Psr16Cache(new FilesystemAdapter('unleash_cache_dev', 3600, __DIR__ . "/cache"));
$cache_prod = new Psr16Cache(new FilesystemAdapter('unleash_cache_prod', 3600, __DIR__ . "/cache"));


$context = (new \Unleash\Client\Configuration\UnleashContext())
    ->setCustomProperty('early_adopters', 'decathlon') // 🔥 Valor a ser validado na regra da feature flag
    ->setCurrentUserId('999'); // Opcional: pode enviar outros dados do usuário

$context2 = (new \Unleash\Client\Configuration\UnleashContext())
    ->setCustomProperty('early_adopters', 'decathlon') // 🔥 Valor a ser validado na regra da feature flag
    ->setCurrentUserId('99'); // Opcional: pode enviar outros dados do usuário

$context3 = (new \Unleash\Client\Configuration\UnleashContext())
    ->setCustomProperty('early_adopters', 'decathlon') // 🔥 Valor a ser validado na regra da feature flag
    ->setCurrentUserId('999'); // Opcional: pode enviar outros dados do usuário

// 🔥 Dev
$unleashDev = UnleashBuilder::create()
    ->withAppName('Casa e Vídeo') //nome do cliente
    ->withAppUrl('http://localhost:4242/api/') //url do endpoint onde está hospedado
    ->withHeader('Authorization', 'default:development.cd639059d6e0e182bffc3860b514304c5a925632f333737b81879eda')
    ->withInstanceId('1')
    ->withCacheHandler($cache_dev)
    ->build();

d('feature_a', $unleashDev->isEnabled('feature_a'), 'desabilitado');
d('feature_b', $unleashDev->isEnabled('feature_b'), 'habilitado');
d('feature_c', $unleashDev->isEnabled('feature_c'), 'não existe, desablitado');
d('feature_d', $unleashDev->isEnabled('feature_d', $context), 'desabilitado em development');
d('feature_f', $unleashDev->isEnabled('feature_f', $context3), 'estava em testes para decathlon e liberou pra todo mundo');

d('Produção');

// 🔥 Prod
$unleashProd = UnleashBuilder::create()
    ->withAppName('Decathlon')
    ->withAppUrl('http://localhost:4242/api/')
    ->withHeader('Authorization', 'default:production.4a1739a3a4c05f5caf3e1a97a8c07cffa5b1725b0eda0f20c8416941')
    ->withInstanceId('2')
    ->withCacheHandler($cache_prod)
    ->build();

d('feature_a', $unleashProd->isEnabled('feature_a'), 'habilitado');
d('feature_b', $unleashProd->isEnabled('feature_b'), 'desabilitado');
d('feature_c', $unleashProd->isEnabled('feature_c'), 'não existe');
d('feature_d', $unleashProd->isEnabled('feature_d'), 'não habilitado em production para todos');

d('early adopters');

d('feature_d', $unleashProd->isEnabled('feature_d', $context), 'somente para decathlon em produção');
d('feature_e', $unleashProd->isEnabled('feature_e', $context), 'somente para decathlon em produção e o usuário id 999');
d('feature_e', $unleashProd->isEnabled('feature_e', $context2), 'desabilitado, é decathon, mas usuário id 99');
d('feature_f', $unleashProd->isEnabled('feature_f'), 'estava em testes para decathlon e liberou pra todo mundo');
