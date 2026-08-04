<?php

if (!defined('ABSPATH')) {
    exit;
}

$storage = new WPAIPDF_PDF_Storage();
$pdfs = $storage->get_all_pdfs();
?>

<div class="wrap">

    <h1>AI PDF Chat</h1>

    <?php if (empty($pdfs)) : ?>

        <p>Please upload a PDF first.</p>

    <?php else : ?>

        <label><strong>Select PDF</strong></label>

        <select id="wpaipdf-pdf-select">

            <?php foreach ($pdfs as $pdf) : ?>

                <option
                    value="<?php echo esc_attr($pdf['path']); ?>">
                    <?php echo esc_html($pdf['name']); ?>
                </option>

            <?php endforeach; ?>

        </select>

        <br><br>

        <label><strong>Your Question</strong></label>

        <textarea
            id="wpaipdf-question"
            rows="6"
            style="width:100%;"></textarea>

        <br><br>

        <button
            id="wpaipdf-ask-btn"
            class="button button-primary">
            Ask AI
        </button>

        <hr>

        <h2>Response</h2>

        <div
            id="wpaipdf-response"
            style="background:#fff;border:1px solid #ddd;padding:15px;min-height:120px;">
        </div>

    <?php endif; ?>

</div>