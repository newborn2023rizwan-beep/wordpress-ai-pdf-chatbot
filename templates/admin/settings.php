<?php

if (!defined('ABSPATH')) {
    exit;
}

if (isset($_POST['wpaipdf_save_settings'])) {

    check_admin_referer('wpaipdf_settings');

    update_option(
        'wpaipdf_openai_api_key',
        sanitize_text_field($_POST['wpaipdf_openai_api_key'])
    );

    echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully.</p></div>';
}

$api_key = get_option('wpaipdf_openai_api_key', '');

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

        </table>

        <?php submit_button(
            'Save Settings',
            'primary',
            'wpaipdf_save_settings'
        ); ?>

    </form>

</div>