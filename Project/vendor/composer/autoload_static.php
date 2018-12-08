<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5885c576aa550bac91797511782f5a53
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Ninja\\' => 6,
        ),
        'J' => 
        array (
            'Jokerdb\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ninja\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/Ninja',
        ),
        'Jokerdb\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/Jokerdb',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5885c576aa550bac91797511782f5a53::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5885c576aa550bac91797511782f5a53::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}