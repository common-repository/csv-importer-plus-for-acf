<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CIPFA_FileHandler extends CIPFA_BaseController
{
   // Function to handle CSV import
   public static function cipfa_handle_csv_import()
   {
      // Verify nonce before processing the CSV file upload
      if (isset($_POST['cipfa_nonce_field'])) {
         $nonce = sanitize_text_field(wp_unslash($_POST['cipfa_nonce_field']));
         if (!wp_verify_nonce($nonce, 'cipfa_nonce')) {
            wp_die(esc_html__('Nonce verification failed. Please try again.', 'csv-importer-plus-for-acf'));
         }
      } else {
         wp_die(esc_html__('Nonce field is missing.', 'csv-importer-plus-for-acf'));
      }

      //Check if CSV file is uploaded
      if (empty($_FILES['csv_file']['tmp_name'])) {
         echo '<div class="error"><p>' . esc_html__('No CSV file uploaded.', 'csv-importer-plus-for-acf') . '</p></div>';
         return;
      }
      // Display CSV mapping form
      require_once(parent::$plugin_path . 'templates/mapping-form.php');
      // Display Progress & logs
      require_once(parent::$plugin_path . 'templates/progress.php');
   }

   // Function to clean hidden or unexpected characters from column name
   public static function cipfa_clean_column_name($name)
   {
      return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($name));
   }
}
