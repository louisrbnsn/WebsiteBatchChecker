<?php
/**
 * Helper functions for URL generation
 */

/**
 * Generate a URL with the correct base path
 * 
 * @param string $path The path (e.g., '/batches', '/batches/create')
 * @return string The full URL with base path
 */
function url($path) {
    // Validate path starts with /
    if (!is_string($path) || strlen($path) === 0 || $path[0] !== '/') {
        $path = '/' . ltrim($path, '/');
    }
    
    $basePath = dirname($_SERVER['SCRIPT_NAME']);
    if ($basePath === '/') {
        return $path;
    }
    return $basePath . $path;
}

/**
 * Redirect to a path with the correct base path
 * 
 * @param string $path The path to redirect to
 * @return void
 */
function redirect($path) {
    header('Location: ' . url($path));
    exit;
}
