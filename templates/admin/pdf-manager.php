<?php

if (!defined('ABSPATH')) {
    exit;
}

$storage = new WPAIPDF_PDF_Storage();
$pdfs = $storage->get_all_pdfs();

?>

<div class="wrap">

    <h1>PDF Manager</h1>

    <p>Upload and manage your PDF knowledge base.</p>

    <hr>

    <h2>Upload PDF</h2>

    <form id="wpaipdf-upload-form" enctype="multipart/form-data">

        <input
            type="file"
            id="wpaipdf_pdf_file"
            name="pdf_file"
            accept=".pdf"
            required>

        <button
            type="submit"
            class="button button-primary">
            Upload PDF
        </button>

    </form>

    <div id="wpaipdf-upload-message"></div>

    <hr>

    <h2>Uploaded PDFs</h2>

    <table class="widefat striped">

        <thead>
            <tr>
                <th width="60%">File Name</th>
                <th width="20%">Type</th>
                <th width="20%">Action</th>
            </tr>
        </thead>

        <tbody>

            <?php if (empty($pdfs)) : ?>

                <tr>
                    <td colspan="3">No PDF uploaded yet.</td>
                </tr>

            <?php else : ?>

                <?php foreach ($pdfs as $pdf) : ?>

                    <tr>

                        <td>
                            <?php echo esc_html($pdf['name']); ?>
                        </td>

                        <td>
                            PDF
                        </td>

                        <td>
                            <button
                                type="button"
                                class="button button-secondary wpaipdf-delete-btn"
                                data-id="<?php echo esc_attr($pdf['id'] ?? ''); ?>"
                                data-path="<?php echo esc_attr($pdf['path']); ?>">
                                Delete
                            </button>
                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

        </tbody>

    </table>

</div>