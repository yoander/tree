<?php
define('TREE_ROOT_DIR', __DIR__);
define('TREE_VENDOR_DIR', TREE_ROOT_DIR . '/vendor');

require_once TREE_VENDOR_DIR . '/voltus-autoloader/src/Psr4Autoloader.php';

// instantiate the loader
$loader = new \Voltus\Autoloader\Psr4Autoloader();

// register the autoloader
$loader->register();

// register the base directories for the namespace prefix
$loader->addNamespace('Tree', TREE_ROOT_DIR . '/src/');
$loader->addNamespace('Voltus\Pattern', __DIR__ . '/vendor/voltus-pattern/src');
$loader->addNamespace('Voltus\Slugify', __DIR__ . '/vendor/voltus-slugify/src');
$loader->addNamespace('Voltus\File', __DIR__ . '/vendor/voltus-file/src');
