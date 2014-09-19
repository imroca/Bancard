<?php

/**
 * The MIT License (MIT)
 * 
 * Copyright (c) 2014 Online Ventures.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 */

/**
 * PSR-4 Autoloader.
 */

spl_autoload_register(function ($class) {
    // Project-specific namespace prefix.
    $prefix = 'LlevaUno\\Bancard\\';
    // Base directory for the namespace prefix.
    $base_dir = __DIR__ . '/';
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
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    // If the file exists, require it.
    if (file_exists($file)) {
        require $file;
    }
});
