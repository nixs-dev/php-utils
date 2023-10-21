<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7377f406e63efb94b4db61c71f706aba
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPUtils\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPUtils\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7377f406e63efb94b4db61c71f706aba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7377f406e63efb94b4db61c71f706aba::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7377f406e63efb94b4db61c71f706aba::$classMap;

        }, null, ClassLoader::class);
    }
}
