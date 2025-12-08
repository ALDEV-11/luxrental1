<?php
/**
 * LuxRental - Path Configuration
 * Centralized path management untuk memudahkan include files
 */

// Define root path
define('ROOT_PATH', dirname(__DIR__));

// Define main directories
define('CONFIG_PATH', ROOT_PATH . '/config');
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('UPLOADS_PATH', ROOT_PATH . '/uploads');

// Define includes subdirectories  
define('AUTH_PATH', INCLUDES_PATH . '/auth');
define('PAGES_PATH', INCLUDES_PATH . '/pages');
define('PROCESS_PATH', INCLUDES_PATH . '/process');
define('COMPONENTS_PATH', INCLUDES_PATH . '/components');

// Helper function untuk include files
function include_config($file) {
    return include CONFIG_PATH . '/' . $file;
}

function include_page($file) {
    return include PAGES_PATH . '/' . $file;
}

function include_process($file) {
    return include PROCESS_PATH . '/' . $file;
}

function include_component($file) {
    return include COMPONENTS_PATH . '/' . $file;
}

function require_config($file) {
    return require CONFIG_PATH . '/' . $file;
}

function require_page($file) {
    return require PAGES_PATH . '/' . $file;
}

function require_process($file) {
    return require PROCESS_PATH . '/' . $file;
}

function require_component($file) {
    return require COMPONENTS_PATH . '/' . $file;
}
?>
