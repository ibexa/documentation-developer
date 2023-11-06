<?php declare(strict_types=1);

namespace App\MyFeature;

class MyFeatureService {
    public function load(int $myFeatureId) {
        return new MyFeature(['id' => $myFeatureId, 'name' => 'Actual Name']);
    }
}
