<?php

if (!defined('ABSPATH')) {
    exit;
}

$pdfs = get_option('wpaipdf_uploaded_pdfs', array());

if (isset($_POST['wpaipdf_save_settings'])) {

    check_admin_referer('wpaipdf_settings');

    update_option(
        'wpaipdf_openai_api_key',
        sanitize_text_field($_POST['wpaipdf_openai_api_key'])
    );

    update_option(
        'wpaipdf_active_pdf',
        sanitize_text_field($_POST['wpaipdf_active_pdf'])
    );

    echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully.</p></div>';
}

$api_key = get_option('wpaipdf_openai_api_key', '');

$active_pdf = get_option('wpaipdf_active_pdf', '');

?>

<div class="wrap">

    <h1>Settings</h1>

    <form method="post">

        <?php wp_nonce_field('wpaipdf_settings'); ?>

        <table class="form-table">

            <tr>

                <th scope="row">
                    OpenAI API Key
                </th>

                <td>

                    <input
                        type="password"
                        name="wpaipdf_openai_api_key"
                        value="<?php echo esc_attr($api_key); ?>"
                        class="regular-text">

                    <p class="description">
                        Paste your OpenAI API Key here.
                    </p>

                </td>

            </tr>

            <tr>

                <th scope="row">
                    Active PDF
                </th>

                <td>

                    <select
                        name="wpaipdf_active_pdf"
                        class="regular-text">

                        <option value="">
                            Select PDF
                        </option>

                        <?php foreach ($pdfs as $pdf) : ?>

                            <option
                                value="<?php echo esc_attr($pdf['path']); ?>"
                                <?php selected($active_pdf, $pdf['path']); ?>>

                                <?php echo esc_html($pdf['name']); ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                    <p class="description">
                        This PDF will be used by the frontend chatbot.
                    </p>

                </td>

            </tr>

        </table>

        <?php submit_button(
            'Save Settings',
            'primary',
            'wpaipdf_save_settings'
        ); ?>

    </form>

</div>