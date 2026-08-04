<?php

if (!defined('ABSPATH')) {
    exit;
}

class WPAIPDF_Chat
{
    public function __construct()
    {
        add_action(
            'wp_ajax_wpaipdf_chat',
            array($this, 'chat')
        );
    }

    public function chat()
    {
        $pdf_path = sanitize_text_field($_POST['pdf_path'] ?? '');
        $question = sanitize_text_field($_POST['question'] ?? '');

        if (empty($pdf_path) || empty($question)) {
            wp_send_json_error('PDF or question is missing.');
        }

        $openai = new WPAIPDF_OpenAI();

        // Upload PDF
        $upload = $openai->upload_file($pdf_path);

        if (!$upload['success']) {
            wp_send_json_error($upload['message']);
        }

        // Ask Question
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
