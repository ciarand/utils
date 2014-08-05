<?php require 'vendor/autoload.php';

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iter = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir = __DIR__ . '/src/');

$versions = GitVersionCollection::create($dir)
    ->add('master', 'master branch');

return new Sami(
    $iter,
    [
        'theme'                => 'enhanced',
        'versions'             => $versions,
        'default_opened_level' => 1,
        'build_dir'            => __DIR__.'/docs/%version%',
        'cache_dir'            => __DIR__.'/docs/cache/%version%',
    ]
);
