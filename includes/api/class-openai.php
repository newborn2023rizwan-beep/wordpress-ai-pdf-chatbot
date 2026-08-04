<?php

if (!defined('ABSPATH')) {
    exit;
}

class WPAIPDF_OpenAI
{
    private $api_key;

    public function __construct()
    {
        $this->api_key = get_option('wpaipdf_openai_api_key');
    }

    public function upload_file($file_path)
    {
        if (empty($this->api_key)) {
            return array(
                'success' => false,
                'message' => 'OpenAI API Key not found.',
            );
        }

        if (!file_exists($file_path)) {
            return array(
                'success' => false,
                'message' => 'PDF file not found.',
            );
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.openai.com/v1/files',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->api_key,
            ),
            CURLOPT_POSTFIELDS => array(
                'purpose' => 'user_data',
                'file' => new CURLFile(
                    $file_path,
                    'application/pdf',
                    basename($file_path)
                ),
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {

            $error = curl_error($curl);

            curl_close($curl);

            return array(
                'success' => false,
                'message' => $error,
            );
        }

        curl_close($curl);

        $body = json_decode($response, true);

        if (isset($body['id'])) {
            return array(
                'success' => true,
                'file_id' => $body['id'],
            );
        }

        return array(
            'success' => false,
            'message' => $body,
        );
    }

    public function ask_question($file_id, $question)
    {
        $payload = array(
            'model' => 'gpt-4.1-mini',
            'input' => array(
                array(
                    'role' => 'user',
                    'content' => array(
                        array(
                            'type' => 'input_file',
                            'file_id' => $file_id,
                        ),
                        array(
                            'type' => 'input_text',
                            'text' => $question,
                        ),
                    ),
                ),
            ),
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.openai.com/v1/responses',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->api_key,
                'Content-Type: application/json',
            ),
            CURLOPT_POSTFIELDS => json_encode($payload),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {

            $error = curl_error($curl);

            curl_close($curl);

            return array(
                'success' => false,
                'message' => $error,
            );
        }

        curl_close($curl);

        $body = json_decode($response, true);

        // Responses API থেকে উত্তর বের করার চেষ্টা
        if (isset($body['output'][0]['content'][0]['text'])) {

            return array(
                'success' => true,
                'answer' => $body['output'][0]['content'][0]['text'],
            );
        }

        if (isset($body['output_text'])) {

            return array(
                'success' => true,
                'answer' => $body['output_text'],
            );
        }

        return array(
            'success' => false,
            'message' => $body,
        );
    }
}
