<?php

/**
 *
 * PSR-4 Autoloader.
 *
 */

spl_autoload_register(function ($class) {
    // Project-specific namespace prefix.
    $prefix = 'Bancard\\Bancard\\';
    // Base directory for the namespace prefix.
    $base_dir = __DIR__ . DIRECTORY_SEPARATOR;
    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // No, move to the next registered autoloader.
        return;
    }
    // Get the relative class name.
    $relative_class = substr($class, $len);
    // Replace the namespace prefix with the base directory, replace namespace
    // Separators with directory separators in the relative class name, append
    // With .php
    $file = $base_dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.php';
    // If the file exists, require it.
    if (file_exists($file)) {
        require $file;
    }
});
