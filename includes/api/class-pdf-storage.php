<?php

if (!defined('ABSPATH')) {
    exit;
}

class WPAIPDF_PDF_Storage
{
    private $option_name = 'wpaipdf_uploaded_pdfs';

    public function get_all_pdfs()
    {
        return get_option($this->option_name, array());
    }

    public function save_pdf($pdf)
    {
        $pdfs = $this->get_all_pdfs();

        $pdfs[] = $pdf;

        update_option($this->option_name, $pdfs);
    }

    public function delete_pdf($id = '', $path = '')
    {
        $pdfs = $this->get_all_pdfs();

        foreach ($pdfs as $key => $pdf) {

            // New PDF (ID exists)
            if (!empty($id) && isset($pdf['id']) && $pdf['id'] === $id) {
                unset($pdfs[$key]);
                break;
            }

            // Legacy PDF (delete by path)
            if (!empty($path) && isset($pdf['path']) && $pdf['path'] === $path) {
                unset($pdfs[$key]);
                break;
            }
        }

        update_option($this->option_name, array_values($pdfs));
    }

    public function get_pdf($id)
    {
        foreach ($this->get_all_pdfs() as $pdf) {

            if (isset($pdf['id']) && $pdf['id'] === $id) {
                return $pdf;
            }
        }

        return null;
    }
}
