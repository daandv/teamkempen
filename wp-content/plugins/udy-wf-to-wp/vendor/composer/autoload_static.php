<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit94c38a0651f0a4b01cd7c2a17149d73f
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Valitron\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Valitron\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/valitron/src/Valitron',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit94c38a0651f0a4b01cd7c2a17149d73f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit94c38a0651f0a4b01cd7c2a17149d73f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
