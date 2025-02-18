<?php
include('vendor/autoload.php');
use Flagsmith\Flagsmith;

$flagsmith = new Flagsmith('');


$userIdentifier = "";

$traits = (object)['sellercenter_name' => 'decathlon', 'user_id' => 999, 'http_address' => 'http://127.0.0.1'];

// 🔥 Obter flags personalizadas com segmentação
$flags = $flagsmith->getIdentityFlags($userIdentifier, $traits);


$feature_a = $flags->isFeatureEnabled('feature_a');
$feature_b = $flags->isFeatureEnabled('feature_b');
$feature_c = $flags->isFeatureEnabled('feature_c');
$feature_d = $flags->isFeatureEnabled('feature_d');
d($feature_a, $feature_b, $feature_c, $feature_d);

//Para cache? Precisa implementar solução com redis