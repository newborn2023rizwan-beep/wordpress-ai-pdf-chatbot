<?php

if (!defined('ABSPATH')) {
    exit;
}

define('WPAIPDF_VERSION', '1.0.0');

define('WPAIPDF_PLUGIN_FILE', dirname(__DIR__, 2) . '/wordpress-ai-pdf-chatbot.php');

define('WPAIPDF_PLUGIN_DIR', plugin_dir_path(WPAIPDF_PLUGIN_FILE));

define('WPAIPDF_PLUGIN_URL', plugin_dir_url(WPAIPDF_PLUGIN_FILE));

define('WPAIPDF_PLUGIN_BASENAME', plugin_basename(WPAIPDF_PLUGIN_FILE));

define('WPAIPDF_TEXT_DOMAIN', 'wordpress-ai-pdf-chatbot');
