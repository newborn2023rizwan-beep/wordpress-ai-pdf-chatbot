<?php

if (!defined('ABSPATH')) {
    exit;
}

class WPAIPDF_Admin_Menu
{
    public function register_menu()
    {
        add_menu_page(
            'AI PDF Chatbot',
            'AI PDF Chatbot',
            'manage_options',
            'wpaipdf-dashboard',
            array($this, 'dashboard_page'),
            'dashicons-format-chat',
            30
        );

        add_submenu_page(
            'wpaipdf-dashboard',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'wpaipdf-dashboard',
            array($this, 'dashboard_page')
        );

        add_submenu_page(
            'wpaipdf-dashboard',
            'PDF Manager',
            'PDF Manager',
            'manage_options',
            'wpaipdf-pdf-manager',
            array($this, 'pdf_manager_page')
        );

        add_submenu_page(
            'wpaipdf-dashboard',
            'Chat Widget',
            'Chat Widget',
            'manage_options',
            'wpaipdf-chat-widget',
            array($this, 'chat_widget_page')
        );

        add_submenu_page(
            'wpaipdf-dashboard',
            'Settings',
            'Settings',
            'manage_options',
            'wpaipdf-settings',
            array($this, 'settings_page')
        );

        add_submenu_page(
            'wpaipdf-dashboard',
            'Logs',
            'Logs',
            'manage_options',
            'wpaipdf-logs',
            array($this, 'logs_page')
        );
    }

    public function dashboard_page()
    {
        require_once WPAIPDF_PLUGIN_DIR . 'templates/admin/dashboard.php';
    }

    public function pdf_manager_page()
    {
        require_once WPAIPDF_PLUGIN_DIR . 'templates/admin/pdf-manager.php';
    }

    public function chat_widget_page()
    {
        require_once WPAIPDF_PLUGIN_DIR . 'templates/admin/chat-widget.php';
    }

    public function settings_page()
    {
        require_once WPAIPDF_PLUGIN_DIR . 'templates/admin/settings.php';
    }

    public function logs_page()
    {
        require_once WPAIPDF_PLUGIN_DIR . 'templates/admin/logs.php';
    }
}
