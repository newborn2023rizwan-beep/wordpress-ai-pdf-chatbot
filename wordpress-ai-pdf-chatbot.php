<?php

/**
 * Plugin Name: WordPress AI PDF Chatbot
 * Plugin URI: https://example.com
 * Description: Upload PDFs and let visitors chat with your documents using OpenAI.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: wordpress-ai-pdf-chatbot
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/core/constants.php';

require_once WPAIPDF_PLUGIN_DIR . 'includes/core/class-loader.php';
require_once WPAIPDF_PLUGIN_DIR . 'includes/core/class-activator.php';

register_activation_hook(__FILE__, array('WPAIPDF_Activator', 'activate'));
register_deactivation_hook(__FILE__, array('WPAIPDF_Deactivator', 'deactivate'));

$loader = new WPAIPDF_Loader();
$loader->run();
