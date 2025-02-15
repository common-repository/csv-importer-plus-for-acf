<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcaa9bb5db2630e3894662fe0189c351a
{
    public static $files = array (
        '9e4824c5afbdc1482b6025ce3d4dfde8' => __DIR__ . '/..' . '/league/csv/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'League\\Csv\\' => 11,
        ),
        'C' => 
        array (
            'CIPFA\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'League\\Csv\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/csv/src',
        ),
        'CIPFA\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcaa9bb5db2630e3894662fe0189c351a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcaa9bb5db2630e3894662fe0189c351a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitcaa9bb5db2630e3894662fe0189c351a::$classMap;

        }, null, ClassLoader::class);
    }
}
