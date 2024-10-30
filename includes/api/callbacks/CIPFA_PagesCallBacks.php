<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\api\callbacks;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use CIPFA\base\CIPFA_BaseController;
use CIPFA\base\CIPFA_FileHandler;

class CIPFA_PagesCallBacks extends CIPFA_BaseController
{

   // csv acf importer form callback
   public function cipfa_csvAcfImporterForm()
   {
      // Check if the form is submitted and handle CSV import logic
      if (isset($_POST['next'])) {
         if (isset($_POST['cipfa_nonce_field'])) {
            // Unsplash and sanitize the input
            $nonce_field = sanitize_text_field(wp_unslash($_POST['cipfa_nonce_field']));
            if (wp_verify_nonce($nonce_field, 'cipfa_nonce')) {
               // Handle CSV import logic if it hasn't been executed already
               if (get_option('cipfa_import_completed') !== true) {
                  CIPFA_FileHandler::cipfa_handle_csv_import();
                  // Set option to mark import completion
                  update_option('cipfa_import_completed', true);
               }
            } else {
               // Nonce verification failed, show error or exit
               wp_die(esc_html__('Nonce verification failed.', 'csv-importer-plus-for-acf'));
            }
         } else {
            // Nonce field is not set, show error or exit
            wp_die(esc_html__('Nonce field is missing.', 'csv-importer-plus-for-acf'));
         }
         return; // Stop further execution to prevent page refresh
      }

      // Display import form
      require_once(parent::$plugin_path . 'templates/upload-form.php');
   }
   // upgrade callback
   public function cipfa_upgradePageCallback()
   {
      require_once(parent::$plugin_path . 'templates/upgrade.php');
   }
}
