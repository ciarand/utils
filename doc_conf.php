<?php require 'vendor/autoload.php';

use Sami\Sami;

return new Sami(
    './src/',
    [
        'default_opened_level' => 2,
        'build_dir'            => __DIR__.'/docs/%version%',
        'cache_dir'            => __DIR__.'/docs/cache/%version%',
    ]
);
