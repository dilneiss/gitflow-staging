<?php

class FlagsmithFileCache {
    private $cacheDir;
    private $flagsmith;
    private $cacheTtl;

    public function __construct($flagsmith, $cacheDir = __DIR__ . "/cache", $ttl = 3600) {
        $this->cacheDir = $cacheDir;
        $this->flagsmith = $flagsmith;
        $this->cacheTtl = $ttl;
        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    private function getFilePath($userIdentifier, $traits) {
        return $this->cacheDir . "/flags_" . md5($userIdentifier . json_encode($traits)) . ".json";
    }

    public function getFlags($userIdentifier, $traits) {
        $cacheFile = $this->getFilePath($userIdentifier, $traits);

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $this->cacheTtl) {
            echo "✅ Carregado do cache de arquivo!\n";
            return json_decode(file_get_contents($cacheFile), true);
        }

        echo "🔄 Consultado da API e salvo no cache!\n";
        $flags = $this->flagsmith->getIdentityFlags($userIdentifier, $traits);

        $flagsData = [
            'features' => [],
            'updated_at' => time()
        ];

        foreach ($flags->allFlags() as $flag) {
            $flagsData['features'][$flag->getFeatureName()] = $flag->getEnabled();
        }

        file_put_contents($cacheFile, json_encode($flagsData));

        return $flagsData;
    }

    public function isFeatureEnabled($featureName, $userIdentifier, $traits) {
        $cacheDir = __DIR__ . "/cache";
        $cacheFile = $cacheDir . "/flags_" . md5($userIdentifier . json_encode($traits)) . ".json";

        // 🔥 Verifica se o cache existe
        if (file_exists($cacheFile)) {
            $flagsData = json_decode(file_get_contents($cacheFile), true);

            // 🔹 Verifica se a feature está presente no cache
            return isset($flagsData['features'][$featureName]) && $flagsData['features'][$featureName];
        }

        // ❌ Se não existir cache, assume que a feature está desativada
        return false;
    }


}
