<?php

if (!defined('ABSPATH')) {
    exit;
}

class WPAIPDF_Chat
{
    public function __construct()
    {
        // Logged-in Users
        add_action(
            'wp_ajax_wpaipdf_chat',
            array($this, 'chat')
        );

        // Frontend Visitors
        add_action(
            'wp_ajax_nopriv_wpaipdf_chat',
            array($this, 'chat')
        );
    }

    public function chat()
    {
        $question = sanitize_text_field($_POST['question'] ?? '');

        if (empty($question)) {
            wp_send_json_error('Question is missing.');
        }

        // Get Active PDF
        $pdf_path = get_option('wpaipdf_active_pdf', '');

        if (empty($pdf_path)) {
            wp_send_json_error('No active PDF selected.');
        }

        $openai = new WPAIPDF_OpenAI();

        // Step 1: Upload PDF
        $upload = $openai->upload_file($pdf_path);

        if (!$upload['success']) {
            wp_send_json_error($upload['message']);
        }

        // Step 2: Ask OpenAI
        $answer = $openai->ask_question(
            $upload['file_id'],
            $question
        );

        if (!$answer['success']) {
            wp_send_json_error($answer['message']);
        }

        wp_send_json_success(array(
            'answer' => $answer['answer'],
        ));
    }
}
