<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitUmpPayStack
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'UmpPayStack\\Admin\\' => 18,
            'UmpPayStack\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'UmpPayStack\\Admin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/admin',
        ),
        'UmpPayStack\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitUmpPayStack::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitUmpPayStack::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitUmpPayStack::$classMap;

        }, null, ClassLoader::class);
    }
}
