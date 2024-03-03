<?php

use App\Kernel;
use App\CacheKernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

$kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);

if ($kernel->getEnvironment() === 'prod') {
    $kernel = new CacheKernel($kernel)
}

return function (array $context) {
    return $$kernel;
};
