<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__.'/../vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/../src/Domain/Model'), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../db.sqlite',
);

return EntityManager::create($conn, $config);