<?php

/**
 * @package CsvImporterPlusforACF
 */

namespace CIPFA\base;

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use DateTime;

class CIPFA_PostProcessor
{
   // Function to process a chunk of CSV data and return the number of posts imported
   public static function cipfa_process_chunk($chunk, $mapping, $post_type, $edit_existing, &$view_logs)
   {
      // Initialize total imported count for this chunk
      $total_imported_chunk = 0;

      // Loop through chunk
      foreach ($chunk as $row) {
         // Process row and update total imported count for this chunk
         $total_imported_chunk += self::cipfa_process_row($row, $mapping, $post_type, $edit_existing, $view_logs);
      }

      return $total_imported_chunk; // Return total imported count for this chunk
   }

   // Function to process a row of CSV data and return the number of posts imported
   public static function cipfa_process_row($row, $mapping, $post_type, $edit_existing, &$view_logs)
   {
      // Step 1: Prepare the post data
      $post_data = self::cipfa_prepare_post_data($mapping, $row, $post_type);
      $acf_fields = $post_data['acf_fields'];
      $post_category = $post_data['post_category'];
      $post_tags = $post_data['post_tags'];
      $post_featured_image = $post_data['post_featured_image'];
      $csv_post_id = $post_data['csv_post_id'];

      // Step 2: Handle the post author
      $post_data['post_author'] = self::cipfa_handle_post_author(
         $post_data['post_author'],
         isset($post_data['post_author_email']) ? $post_data['post_author_email'] : null
      );

      // Step 3: Insert or update the post
      $post_id = self::cipfa_insert_or_update_post($post_data, $edit_existing, $csv_post_id);

      // If post insertion or update failed, return 0
      if ($post_id == 0) {
         return 0;
      }

      // Step 4: Set featured image
      self::cipfa_set_featured_image($post_id, $post_featured_image);

      // Step 5: Set categories
      self::cipfa_set_categories($post_id, $post_category);

      // Step 6: Set tags
      self::cipfa_set_tags($post_id, $post_tags);

      // Step 7: Update ACF fields
      self::cipfa_update_acf_fields($post_id, $acf_fields);

      return 1; // Return 1 as one row has been processed
   }

   //Prepare Post Data
   private static function cipfa_prepare_post_data($mapping, $row, $post_type)
   {
      $post_data = array(
         'post_title' => '',
         'post_date' => '',
         'post_content' => '',
         'post_excerpt' => '',
         'post_type' => $post_type,
         'post_status' => 'publish',
         'post_author' => '',
         'post_parent' => '',
         'menu_order' => '',
         'page_template' => '',
         'comment_status' => 'open',
         'ping_status' => 'open',
      );

      $acf_fields = array();
      $post_tags = array();
      $post_category = array();
      $post_featured_image = '';
      $csv_post_id = '';

      // Retrieve post data from CSV based on the mapping
      foreach ($mapping as $column_name => $field_key) {
         // Ensure the column_name is found in the row array keys
         $column_index = array_search($column_name, array_keys($mapping));
         if ($column_index === false) continue;
         // Retrieve the value from the row
         $column_value = isset($row[$column_index]) ? $row[$column_index] : '';

         switch ($field_key) {
            case 'post_title':
               $post_data['post_title'] = sanitize_text_field($column_value);
               break;
            case 'post_date':
               $date_formats = ['m/d/Y', 'd/m/Y', 'd-M-y', 'Y-m-d'];
               $date_obj = false;
               foreach ($date_formats as $format) {
                  $date_obj = DateTime::createFromFormat($format, $column_value);
                  // Check for parsing errors
                  $errors = DateTime::getLastErrors();
                  if (
                     $date_obj !== false && $errors['warning_count'] === 0 && $errors['error_count'] === 0
                  ) {
                     break;
                  }
                  $date_obj = false; // Reset if parsing failed
               }
               if ($date_obj !== false) {
                  $post_data['post_date'] = $date_obj->format('Y-m-d H:i:s');
               } else {
                  // Set post date to current date and time if parsing fails
                  $post_data['post_date'] = (new DateTime())->format('Y-m-d H:i:s');
               }
               break;
            case 'post_content':
               $post_data['post_content'] = wp_kses_post($column_value);
               break;
            case 'post_excerpt':
               $post_data['post_excerpt'] = sanitize_text_field($column_value);
               break;
            case 'featured_image':
               $post_featured_image = esc_url_raw($column_value);
               break;
            case 'post_category':
               $post_category = array_map('sanitize_text_field', explode(',', $column_value));
               break;
            case 'tags':
               $post_tags = array_map('sanitize_text_field', explode(',', $column_value));
               break;
            case 'post_author':
               $post_data['post_author'] = sanitize_text_field($column_value);
               break;
            case 'post_author_email':
               $post_data['post_author_email'] = sanitize_email($column_value);
               break;
            case 'author_password':
               $post_data['author_password'] = sanitize_text_field($column_value);
               break;
            case 'post_parent':
               if (self::cipfa_is_valid_post_parent($column_value)) {
                  $post_data['post_parent'] = intval($column_value);
               }
               break;
            case 'menu_order':
               $post_data['menu_order'] = intval($column_value);
               break;
            case 'page_template':
               $template_key = self::cipfa_is_valid_page_template($column_value);
               if ($template_key) {
                  $post_data['page_template'] = sanitize_text_field($template_key);
               }
               break;
            case 'post_status':
               $post_data['post_status'] = sanitize_text_field($column_value);
               break;
            case 'comments':
               $post_data['comment_status'] = strtolower(sanitize_text_field($column_value)) === 'disable' ? 'closed' : 'open';
               break;
            case 'pings':
               $post_data['ping_status'] = strtolower(sanitize_text_field($column_value)) === 'disable' ? 'closed' : 'open';
               break;
            case 'post_id':
               $csv_post_id = intval($column_value);
               break;
            default:
               if (strpos($field_key, 'field_') !== false) {
                  $sanitized_data = CIPFA_ACFSanitizer::cipfa_sanitize_acf_data(array($field_key => $column_value));
                  if (is_array($sanitized_data) && isset($sanitized_data[$field_key])) {
                     $acf_fields[$field_key] = $sanitized_data[$field_key];
                  } else {
                     $acf_fields[$field_key] = $sanitized_data;
                  }
               }
               break;
         }
      }

      $post_data['acf_fields'] = $acf_fields;
      $post_data['post_tags'] = $post_tags;
      $post_data['post_category'] = $post_category;
      $post_data['post_featured_image'] = $post_featured_image;
      $post_data['csv_post_id'] = $csv_post_id;

      return $post_data;
   }

   // Validate Post Parent
   private static function cipfa_is_valid_post_parent($post_parent)
   {
      return is_numeric($post_parent) && get_post($post_parent) && get_post_type($post_parent) == 'page';
   }

   // Validate Page Template
   private static function cipfa_is_valid_page_template($page_template_label)
   {
      $available_templates = wp_get_theme()->get_page_templates();
      $template_key = array_search($page_template_label, $available_templates);
      return $template_key !== false ? $template_key : false;
   }

   //Handle Post Author
   private static function cipfa_handle_post_author($post_author, $post_author_email)
   {
      if (!empty($post_author)) {
         // Find user by ID, username, or email
         if (is_numeric($post_author)) {
            $user = get_user_by('ID', $post_author);
         } else {
            $user = get_user_by('login', $post_author);
            if (!$user) {
               $user = get_user_by('email', $post_author);
            }
         }

         if ($user) {
            return $user->ID;
         } else {
            // Create new user if not found
            $username = sanitize_user($post_author);
            $email = sanitize_email($post_author_email);
            $author_password = !empty($author_password) ? $author_password : wp_generate_password();

            $userdata = array(
               'user_login' => $username,
               'user_pass' => $author_password,
               'user_email' => $email,
               'role' => 'author'
            );

            $user_id = wp_insert_user($userdata);

            if (!is_wp_error($user_id)) {
               return $user_id;
            } else {
               $current_user = wp_get_current_user();
               CIPFA_Logs::cipfa_Log('Error creating a new author with email ' . $post_author_email . ': ' . $user_id->get_error_message() . ' Using current author ' . $current_user->user_login);
               return get_current_user_id(); // Use current user if user creation fails
            }
         }
      } else {
         return get_current_user_id();
      }
   }

   //Insert or Update Post
   private static function cipfa_insert_or_update_post($post_data, $edit_existing, $csv_post_id)
   {
      // valid post statuses
      $valid_statuses = array('publish', 'future', 'draft', 'pending', 'private', 'trash', 'auto-draft', 'inherit');

      // Normalize post status to lowercase before validation
      $post_data['post_status'] = strtolower($post_data['post_status']);

      // Validate post status before inserting/updating
      if (!in_array($post_data['post_status'], $valid_statuses)) {
         CIPFA_Logs::cipfa_Log('Invalid post status: ' . $post_data['post_status'] . '. Post ' . $post_data['post_title'] . ' is not inserted or updated.');
         return 0; // Don't proceed with insertion or update
      }

      // Updat a existing post
      if ($edit_existing && !empty($csv_post_id)) {
         $existing_post = get_post($csv_post_id);
         if ($existing_post && in_array($existing_post->post_status, $valid_statuses)) {
            $post_data['ID'] = $csv_post_id;
            $post_id = wp_update_post($post_data);
            // Check for errors while updating the post
            if (is_wp_error($post_id)) {
               CIPFA_Logs::cipfa_Log('Failed to update post with ID ' . $csv_post_id . '. Error: ' . $post_id->get_error_message());
               return 0;
            }
            return $post_id;
         }
      }
      // Insert a new post
      $post_id = wp_insert_post($post_data);

      // Check if post insertion failed
      if (is_wp_error($post_id)) {
         CIPFA_Logs::cipfa_Log('Failed to insert post with title ' . $post_data['post_title'] . '. Error: ' . $post_id->get_error_message());
         return 0;
      }
      return $post_id;
   }

   //Set Featured Image
   private static function cipfa_set_featured_image($post_id, $post_featured_image)
   {
      if ($post_featured_image) {
         $image_id = attachment_url_to_postid($post_featured_image);
         if ($image_id) {
            set_post_thumbnail($post_id, $image_id);
         } else {
            CIPFA_Logs::cipfa_Log('Featured image not found: ' . $post_featured_image . " for post " . $post_id);
         }
      }
   }

   //Set Categories
   private static function cipfa_set_categories($post_id, $post_category)
   {
      if (!empty($post_category)) {
         $category_ids = array();
         $categories = $post_category;
         foreach ($categories as $category_name) {
            $term = term_exists(trim($category_name), 'category');
            if ($term !== 0 && $term !== null) {
               $category_ids[] = $term['term_id'];
            } else {
               $new_term = wp_insert_term(trim($category_name), 'category');
               if (!is_wp_error($new_term)) {
                  $category_ids[] = $new_term['term_id'];
               }
            }
         }
         if (!empty($category_ids)) {
            wp_set_post_terms($post_id, $category_ids, 'category');
         }
      }
   }

   //Set Tags
   private static function cipfa_set_tags($post_id, $post_tags)
   {
      if (!empty($post_tags)) {
         wp_set_post_tags($post_id, $post_tags);
      }
   }

   //Update ACF Fields
   private static function cipfa_update_acf_fields($post_id, $acf_fields)
   {
      if (!empty($acf_fields)) {
         foreach ($acf_fields as $field_key => $field_value) {
            // update ACF fields
            update_field($field_key, $field_value, $post_id);
         }
      }
   }
}
