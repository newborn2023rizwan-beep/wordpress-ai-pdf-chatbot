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
        require_once WPAIPDF_PLUGIN_DIR . 'includes/api/class-openai.php';
        require_once WPAIPDF_PLUGIN_DIR . 'includes/api/class-chat.php';
    }

    private function init_hooks()
    {
        $admin_menu = new WPAIPDF_Admin_Menu();
        $pdf_upload = new WPAIPDF_PDF_Upload();
        $chat = new WPAIPDF_Chat();

        add_action(
            'admin_menu',
            array($admin_menu, 'register_menu')
        );

        add_action(
            'admin_enqueue_scripts',
            array($this, 'enqueue_admin_assets')
        );

        add_action(
            'wp_enqueue_scripts',
            array($this, 'enqueue_frontend_assets')
        );

        add_action(
            'wp_footer',
            array($this, 'render_chat_widget')
        );
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
    }

    public function enqueue_frontend_assets()
    {
        wp_enqueue_style(
            'wpaipdf-chat',
            WPAIPDF_PLUGIN_URL . 'assets/css/chat.css',
            array(),
            WPAIPDF_VERSION
        );

        wp_enqueue_script(
            'wpaipdf-chat',
            WPAIPDF_PLUGIN_URL . 'assets/js/chat.js',
            array(),
            WPAIPDF_VERSION,
            true
        );

        wp_localize_script(
            'wpaipdf-chat',
            'wpaipdf',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
            )
        );
    }

    public function render_chat_widget()
    {
        require WPAIPDF_PLUGIN_DIR . 'templates/frontend/chat-widget.php';
    }
}
