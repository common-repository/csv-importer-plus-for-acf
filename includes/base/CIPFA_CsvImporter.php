<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CIPFA_CsvImporter
{
   public static function cipfa_register()
   {
      add_action('init', array(__CLASS__, 'cipfa_initialize_import_count'));
      add_action('wp_ajax_cipfa_data', array(__CLASS__, 'cipfa_data_ajax'));
   }

   // Initialize total imported posts count option
   public static function cipfa_initialize_import_count()
   {
      if (get_option('cipfa_total_imported_so_far') === false) {
         update_option('cipfa_total_imported_so_far', 0);
      }
   }

   // Function to handle CSV import AJAX request
   public static function cipfa_data_ajax()
   {
      CIPFA_Logs::$view_logs = array(); // Reset error logs for current request

      // Check nonce
      check_ajax_referer('cipfa_nonce', 'cipfa_nonce_field');

      // Get CSV data and mapping
      if (isset($_POST['json_csv_data'])) {

         $csv_data_raw = wp_kses_post(wp_unslash($_POST['json_csv_data']));
         $csv_data = json_decode($csv_data_raw, true);

         // Check if JSON decoding failed
         if (json_last_error() !== JSON_ERROR_NONE) {
            wp_die(esc_html__('Invalid JSON data.', 'csv-importer-plus-for-acf'));
         }
      } else {
         // $_POST['json_csv_data'] is not set, handle the error
         wp_die(esc_html__('CSV data is missing.', 'csv-importer-plus-for-acf'));
      }
      // Get mapping data
      $mapping = isset($_POST['mapping']) ? array_map('sanitize_text_field', wp_unslash($_POST['mapping'])) : array();

      // Get selected post type
      $post_type = isset($_POST['post_type']) ? sanitize_text_field(wp_unslash($_POST['post_type'])) : 'post';

      // Get current chunk index
      $current_chunk = isset($_POST['current_chunk']) ? intval($_POST['current_chunk']) : 0;

      // Get the edit_existing flag
      $edit_existing = isset($_POST['edit_existing']) && $_POST['edit_existing'] === '1';

      // Reset total imported posts count at the start of a new import process
      if ($current_chunk === 0) {
         update_option('cipfa_total_imported_so_far', 0);
      }

      // Get total imported posts count from options
      $cipfa_total_imported_so_far = get_option('cipfa_total_imported_so_far', 0);

      // Get chunk size from request or default to 10
      $chunk_size = isset($_POST['chunk_size']) ? intval($_POST['chunk_size']) : 10;

      // Calculate total chunks
      $total_chunks = ceil(count($csv_data) / $chunk_size);

      // Get current chunk
      $chunk = array_slice($csv_data, $current_chunk * $chunk_size, $chunk_size);

      // Process chunk and update total imported count
      $total_imported_for_chunk = CIPFA_PostProcessor::cipfa_process_chunk($chunk, $mapping, $post_type, $edit_existing, $view_logs);

      // Update total imported count
      $cipfa_total_imported_so_far += $total_imported_for_chunk;

      // Save the updated total imported count back to options
      update_option('cipfa_total_imported_so_far', $cipfa_total_imported_so_far);

      // Check if this is the last chunk
      $is_last_chunk = ($current_chunk + 1) >= $total_chunks;

      // If it is the last chunk, reset the total imported count
      if ($is_last_chunk) {
         update_option('cipfa_total_imported_so_far', 0);
      }
      $html_log_list = '';
      if (!empty(CIPFA_Logs::$view_logs)) {
         // Format the error logs as an HTML list
         $html_log_list = '<ul class="list-disc pl-5">';
         foreach (CIPFA_Logs::$view_logs as $view_log) {
            $html_log_list .= '<li class="text-black text-sm">' . esc_html($view_log) . '</li>';
         }
         $html_log_list .= '</ul>';
      }

      $success_message_template = esc_html__('posts imported successfully! Total chunks imported: ', 'csv-importer-plus-for-acf');
      $success_message = intval($cipfa_total_imported_so_far) . ' ' . $success_message_template . intval($total_chunks);

      // Send response back to the client after the chunk is processed
      wp_send_json_success(array(
         'cipfa_total_imported_so_far' => intval($cipfa_total_imported_so_far),
         'total_chunks' => intval($total_chunks),
         'current_chunk' => intval($current_chunk) + 1,
         'chunk_size' => intval($chunk_size),
         'message' => sanitize_text_field($success_message),
         'logs' => wp_kses_post($html_log_list)
      ));
   }
}
