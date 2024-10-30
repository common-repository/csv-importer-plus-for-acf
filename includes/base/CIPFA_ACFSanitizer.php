<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use DateTime;

class CIPFA_ACFSanitizer
{
   public static function cipfa_sanitize_acf_data($acf_data)
   {
      if (!is_array($acf_data)) {
         return array();
      }

      $sanitized_acf_data = array();
      $date_formats = ['d/m/Y', 'm/d/Y', 'F j, Y', 'Y-m-d'];

      foreach ($acf_data as $key => $value) {
         // Get the field object
         $field = acf_get_field($key);
         if (!$field) {
            // Handle case where acf field is not found
            continue;
         }
         $field_type = $field['type'];

         switch ($field_type) {
            case 'text':
            case 'textarea':
               $sanitized_acf_data[$key] = sanitize_text_field($value);
               break;
            case 'email':
               $sanitized_acf_data[$key] = sanitize_email($value);
               break;
            case 'url':
               $sanitized_acf_data[$key] = esc_url_raw($value);
               break;
            case 'number':
               $sanitized_acf_data[$key] = floatval($value);
               break;
            case 'range':
               $sanitized_acf_data[$key] = intval($value);
               break;
            case 'password':
               $sanitized_acf_data[$key] = sanitize_text_field($value);
               break;
            case 'image':
               if (is_array($value)) {
                  foreach ($value as $subkey => $subvalue) {
                     if (is_numeric($subvalue)) {
                        $sanitized_acf_data[$key][$subkey] = intval($subvalue);
                     } else {
                        $sanitized_acf_data[$key][$subkey] = self::cipfa_get_attachment_id_from_url($subvalue, $key);
                     }
                  }
               } else {
                  if (is_numeric($value)) {
                     $sanitized_acf_data[$key] = intval($value);
                  } else {
                     $sanitized_acf_data[$key] = self::cipfa_get_attachment_id_from_url($value, $key);
                  }
               }
               break;
            case 'select':
               if (is_array($value)) {
                  $sanitized_acf_data[$key] = array_map('sanitize_text_field', $value);
               } else {
                  $sanitized_acf_data[$key] = sanitize_text_field($value);
               }
               break;
            case 'boolean':
               $sanitized_acf_data[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
               break;
            case 'date_picker':
               $date_obj = false;
               foreach ($date_formats as $format) {
                  $date_obj = DateTime::createFromFormat($format, $value);
                  $errors = DateTime::getLastErrors();
                  if ($date_obj !== false && $errors['warning_count'] === 0 && $errors['error_count'] === 0) {
                     $sanitized_acf_data[$key] = $date_obj->format('Y-m-d');
                     break;
                  }
                  $date_obj = false;
               }
               if (!$date_obj) {
                  $sanitized_acf_data[$key] = sanitize_text_field($value);
               }
               break;
            default:
               // Default sanitization
               $sanitized_acf_data[$key] = sanitize_text_field($value);
               break;
         }
      }
      return $sanitized_acf_data;
   }

   //Retrieves the attachment ID from a UR
   private static function cipfa_get_attachment_id_from_url($url, $field_key)
   {
      $sanitized_url = esc_url_raw($url);
      $attachment_id = attachment_url_to_postid($sanitized_url);

      if (!$attachment_id && !empty($sanitized_url)) {
         CIPFA_Logs::cipfa_Log("Image not found for URL: $sanitized_url for field: $field_key");
      }

      return $attachment_id ?: $sanitized_url;
   }
}
