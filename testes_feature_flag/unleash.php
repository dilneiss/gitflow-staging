<?php

require 'vendor/autoload.php';

use Unleash\Client\UnleashBuilder;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

// Criando um cache PSR-16 baseado em arquivos
$cache_dev = new Psr16Cache(new FilesystemAdapter('unleash_cache_dev', 3600, __DIR__ . "/cache"));
$cache_prod = new Psr16Cache(new FilesystemAdapter('unleash_cache_prod', 3600, __DIR__ . "/cache"));

// 🔥 Dev
$unleashDev = UnleashBuilder::create()
    ->withAppName('unleash-onboarding-php')
    ->withAppUrl('https://us.app.unleash-hosted.com/uskk0004/api')
    ->withHeader('Authorization', 'default:development.f5ab3b13741333609cceda53495598cc5490c3405e53674c0682ce3f')
    ->withInstanceId('unleash-onboarding-instance-1')
    ->withCacheHandler($cache_dev)
    ->build();

d($unleashDev->isEnabled('feature_a'));

// 🔥 Prod
$unleashProd = UnleashBuilder::create()
    ->withAppName('unleash-onboarding-php')
    ->withAppUrl('https://us.app.unleash-hosted.com/uskk0004/api')
    ->withHeader('Authorization', 'default:production.6411f09a1587b5796467328fefd8120c4d4ce453263d120c25102c69')
    ->withInstanceId('unleash-onboarding-instance-2')
    ->withCacheHandler($cache_prod)
    ->build();

d($unleashProd->isEnabled('feature_a'));