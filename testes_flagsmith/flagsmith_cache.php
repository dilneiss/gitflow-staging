<?php
include('vendor/autoload.php');
include('FlagsmithFileCache.php');
use Flagsmith\Flagsmith;

$flagsmith = new Flagsmith('');

$cache = new FlagsmithFileCache($flagsmith, __DIR__ . "/cache", 3600);

$userIdentifier = "";

$traits = (object)['sellercenter_name' => 'decathlon', 'user_id' => 999, 'http_address' => 'http://127.0.0.1'];
$flagsData = $cache->getFlags($userIdentifier, $traits);

// 🔥 Obter flags personalizadas com segmentação
$flags = $flagsmith->getIdentityFlags($userIdentifier, $traits);


$feature_a = $flags->isFeatureEnabled('feature_a');
$feature_b = $flags->isFeatureEnabled('feature_b');
$feature_c = $flags->isFeatureEnabled('feature_c');
$feature_d = $flags->isFeatureEnabled('feature_d');
d($feature_a, $feature_b, $feature_c, $feature_d);

//Para cache? Precisa implementar solução com redis
//@todo dificuldade encontrada: cachear todas as features com as traits que validam se é para habilitar ou não
//se mudar muito as traits, como user id, address, ip etc. pode não ser uma boa escolha