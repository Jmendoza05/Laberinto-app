<?php

spl_autoload_register(function ($className) {

    $baseDir = __DIR__ . '/';
    
    if (strpos($className, 'Controller') !== false) {
        $path = $baseDir . 'controllers/' . $className . '.php';
    } elseif (strpos($className, 'Model') !== false || $className === 'User') {
        $path = $baseDir . 'models/' . $className . '.php';
    } elseif (strpos($className, 'Service') !== false) {
        $path = $baseDir . 'services/' . $className . '.php';
    } elseif (strpos($className, 'Routes') !== false) {
        $path = $baseDir . 'routes/' . $className . '.php';
    } elseif ($className === 'Database') {
        $path = $baseDir . 'config/' . $className . '.php';
    } elseif (strpos($className, 'Handler') !== false) {
        $path = $baseDir . 'helpers/' . $className . '.php';
    } else {
        $path = $baseDir . $className . '.php';
    }
    
    if (file_exists($path)) {
        require_once $path;
    }
});
?>