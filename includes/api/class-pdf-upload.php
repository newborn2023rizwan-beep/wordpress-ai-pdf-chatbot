<?php

if (!defined('ABSPATH')) {
    exit;
}

class WPAIPDF_PDF_Upload
{
    private $storage;

    public function __construct()
    {
        $this->storage = new WPAIPDF_PDF_Storage();

        add_action(
            'wp_ajax_wpaipdf_upload_pdf',
            array($this, 'upload_pdf')
        );

        add_action(
            'wp_ajax_wpaipdf_delete_pdf',
            array($this, 'delete_pdf')
        );
    }

    public function upload_pdf()
    {
        if (empty($_FILES['pdf_file'])) {
            wp_send_json_error('No PDF selected.');
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';

        $uploaded_file = wp_handle_upload(
            $_FILES['pdf_file'],
            array(
                'test_form' => false,
            )
        );

        if (isset($uploaded_file['error'])) {
            wp_send_json_error($uploaded_file['error']);
        }

        $pdf = array(
            'id'   => uniqid('pdf_', true),
            'name' => basename($uploaded_file['file']),
            'path' => $uploaded_file['file'],
            'url'  => $uploaded_file['url'],
            'type' => $uploaded_file['type'],
        );

        $this->storage->save_pdf($pdf);

        wp_send_json_success(array(
            'message' => 'PDF uploaded successfully.',
        ));
    }

    public function delete_pdf()
    {
        $id = sanitize_text_field($_POST['id'] ?? '');
        $path = sanitize_text_field($_POST['path'] ?? '');

        if (empty($id) && empty($path)) {
            wp_send_json_error('Invalid PDF.');
        }

        $this->storage->delete_pdf($id, $path);

        wp_send_json_success(array(
            'message' => 'PDF deleted successfully.',
        ));
    }
}
