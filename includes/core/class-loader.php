<?php

if (!defined('ABSPATH')) {
    exit;
}

class WPAIPDF_Loader
{
    public function run()
    {
        $this->load_dependencies();
        $this->init_hooks();
    }

    private function load_dependencies()
    {
        require_once WPAIPDF_PLUGIN_DIR . 'includes/admin/class-admin-menu.php';

        require_once WPAIPDF_PLUGIN_DIR . 'includes/api/class-pdf-storage.php';
        require_once WPAIPDF_PLUGIN_DIR . 'includes/api/class-pdf-upload.php';

        // NEW
        require_once WPAIPDF_PLUGIN_DIR . 'includes/api/class-openai.php';
        require_once WPAIPDF_PLUGIN_DIR . 'includes/api/class-chat.php';
    }

    private function init_hooks()
    {
        $admin_menu = new WPAIPDF_Admin_Menu();

        $pdf_upload = new WPAIPDF_PDF_Upload();

        // NEW
        $chat = new WPAIPDF_Chat();

        add_action('admin_menu', array($admin_menu, 'register_menu'));

        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    public function enqueue_admin_assets($hook)
    {
        if (strpos($hook, 'wpaipdf') === false) {
            return;
        }

        wp_enqueue_script(
            'wpaipdf-admin',
            WPAIPDF_PLUGIN_URL . 'assets/js/admin.js',
            array(),
            WPAIPDF_VERSION,
            true
        );

        wp_enqueue_script(
            'wpaipdf-chat',
            WPAIPDF_PLUGIN_URL . 'assets/js/chat.js',
            array(),
            WPAIPDF_VERSION,
            true
        );
    }
}
