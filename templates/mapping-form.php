<?php

/**
 * @package CsvImporterPlusforACF
 * Mapping Form
 */

?>

<?php

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use League\Csv\Reader;
use League\Csv\Exception;
use League\Csv\SyntaxError;

// Verify nonce before processing the CSV file upload
if (isset($_POST['cipfa_nonce_field'])) {
   $nonce = sanitize_text_field(wp_unslash($_POST['cipfa_nonce_field']));
   if (!wp_verify_nonce($nonce, 'cipfa_nonce')) {
      wp_die(esc_html__('Nonce verification failed. Please try again.', 'csv-importer-plus-for-acf'));
   }
} else {
   wp_die(esc_html__('Nonce field is missing.', 'csv-importer-plus-for-acf'));
}

if (isset($_FILES['csv_file']) && isset($_FILES['csv_file']['tmp_name'])) {
   $csv_file = sanitize_text_field($_FILES['csv_file']['tmp_name']);
}

try {
   // Create a CSV Reader instance
   $csv = Reader::createFromPath($csv_file, 'r');

   // Set the header offset if the first row contains headers
   $csv->setHeaderOffset(0);

   // Get all records as an array of associative arrays
   $records = $csv->getRecords();

   // Convert records to a simple array of arrays
   $csv_data = [];
   foreach ($records as $record) {
      $csv_data[] = array_values($record);
   }

   // Header row
   $header_row = $csv->getHeader();
} catch (SyntaxError $e) {
   // Display the error message using Tailwind CSS and escape the content
   echo '<div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">';
   echo '<strong class="font-bold">' . esc_html__('Error:', 'csv-importer-plus-for-acf') . '</strong> ';
   echo '<span>' . esc_html__('The CSV file contains duplicate column names. Please ensure all column names are unique and try again.', 'csv-importer-plus-for-acf') . '</span>';
   echo '</div>';

   // Stop further code execution
   exit;
} catch (Exception $e) {
   // Display other errors using Tailwind CSS and escape the error message
   echo '<div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">';
   echo '<strong class="font-bold">' . esc_html__('Error:', 'csv-importer-plus-for-acf') . '</strong> ';
   echo '<span>' . esc_html($e->getMessage()) . '</span>';
   echo '</div>';

   // Stop further code execution
   exit;
}

// Get selected post type
$post_type = isset($_POST['post_type']) ? sanitize_text_field(wp_unslash($_POST['post_type'])) : 'post';

// Get chunck size
$chunk_size = isset($_POST['chunk_size']) ? intval($_POST['chunk_size']) : 10;
// Get update check
$edit_existing = isset($_POST['edit_existing']) ? ($_POST['edit_existing'] == '1') : false;
//check if ACF exists
if (class_exists('ACF')) {
   // Get ACF field groups associated with the selected post type
   $acf_field_groups = acf_get_field_groups(array('post_type' => $post_type));
}
// Trim and clean all column names in the header row
$header_row = array_map('CIPFA\base\CIPFA_FileHandler::cipfa_clean_column_name', $header_row);
// Count occurrences of each column name
$column_counts = array_count_values($header_row);
// Determine unique column names
$unique_column_names = array_filter($column_counts, function ($count) {
   return $count === 1;
});
?>
<!-- Display CSV mapping form -->
<div class="max-w-3xl mx-auto mt-8 p-8 bg-white rounded-lg shadow-lg" id="importer-form-container">
   <h2 class="text-2xl mb-8 text-center font-semibold"><?php echo esc_html__('Map CSV Columns to Post Fields and ACF Fields', 'csv-importer-plus-for-acf') ?></h2>
   <form id="mapping-form" method="post" class="space-y-4">
      <input type="hidden" name="json_csv_data" value="<?php $json_csv_data = wp_json_encode($csv_data);
                                                         $json_csv_data = str_replace('\\/', '/', $json_csv_data);
                                                         echo esc_attr($json_csv_data); ?>" />
      <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
      <input type="hidden" name="chunk_size" value="<?php echo esc_attr($chunk_size); ?>" />
      <input type="hidden" name="edit_existing" value="<?php echo esc_attr($edit_existing); ?>" />
      <?php wp_nonce_field('cipfa_nonce', 'cipfa_nonce_field'); ?>
      <input type="hidden" name="action" value="cipfa_data">
      <div class="overflow-x-auto">
         <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
               <tr>
                  <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">
                     <?php echo esc_html__('CSV Column', 'csv-importer-plus-for-acf') ?>
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                     <?php echo esc_html__('Field', 'csv-importer-plus-for-acf') ?>
                  </th>
               </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
               <?php foreach ($header_row as $column_name) : ?>
                  <?php
                  CIPFA\base\CIPFA_FileHandler::cipfa_clean_column_name($column_name);
                  ?>
                  <tr class="border-none">
                     <td class="px-2 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 px-4"><?php echo esc_html($column_name); ?></div>
                     </td>
                     <td class="px-6 py-4 whitespace-nowrap">
                        <select name="mapping[<?php echo esc_attr($column_name); ?>]" class="block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md">
                           <option value=""><?php echo esc_html__('Select Field', 'csv-importer-plus-for-acf') ?></option>
                           <?php if ($post_type != 'page' && $post_type != 'attachment') : ?>
                              <optgroup label="Post Fields">
                                 <?php
                                 if ($edit_existing) { ?>
                                    <option value="post_id" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_id');
                                                            endif; ?>><?php echo esc_html__('Post ID', 'csv-importer-plus-for-acf') ?></option>
                                 <?php } ?>
                                 <option value="post_title" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_title');
                                                            endif; ?>><?php echo esc_html__('Title', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_date" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_date');
                                                            endif; ?>><?php echo esc_html__('Published Date', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_content" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_content');
                                                               endif; ?>><?php echo esc_html__('Content', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_excerpt" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_excerpt');
                                                               endif; ?>><?php echo esc_html__('Excerpt', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="featured_image" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_featured_image');
                                                                  endif; ?>><?php echo esc_html__('Featured Image', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_category" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_categories');
                                                               endif; ?>><?php echo esc_html__('Categories', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="tags" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_tags');
                                                      endif; ?>><?php echo esc_html__('Tags', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_author" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_author_usernames');
                                                               endif; ?>><?php echo esc_html__('Author Usernames', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_author_email" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_author_emails');
                                                                     endif; ?>><?php echo esc_html__('Author Emails', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="author_password" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_author_passwords');
                                                                  endif; ?>><?php echo esc_html__('Author Passwords', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_status" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_status');
                                                               endif; ?>><?php echo esc_html__('Post Status', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="comments" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_comments');
                                                            endif; ?>><?php echo esc_html__('Comments (enable/disable)', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="pings" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'post_pings');
                                                         endif; ?>><?php echo esc_html__('Pings (enable/disable)', 'csv-importer-plus-for-acf') ?></option>
                              </optgroup>
                           <?php elseif ($post_type == 'page') : ?>
                              <optgroup label="Page Fields">
                                 <?php
                                 if ($edit_existing) { ?>
                                    <option value="post_id" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_id');
                                                            endif; ?>><?php echo esc_html__('Post ID', 'csv-importer-plus-for-acf') ?></option>
                                 <?php } ?>
                                 <option value="post_title" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_title');
                                                            endif; ?>><?php echo esc_html__('Title', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_date" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_date');
                                                            endif; ?>><?php echo esc_html__('Published Date', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_content" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_content');
                                                               endif; ?>><?php echo esc_html__('Content', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_excerpt" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_excerpt');
                                                               endif; ?>><?php echo esc_html__('Excerpt', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="featured_image" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_featured_image');
                                                                  endif; ?>><?php echo esc_html__('Featured Image', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_parent" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_parent');
                                                               endif; ?>><?php echo esc_html__('Page\'s Parent', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="menu_order" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'menu_order');
                                                            endif; ?>><?php echo esc_html__('Page\'s Order', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="page_template" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_template');
                                                               endif; ?>><?php echo esc_html__('Page\'s Template', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_author" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_author');
                                                               endif; ?>><?php echo esc_html__('Author Usernames', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_author_email" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_author_email');
                                                                     endif; ?>><?php echo esc_html__('Author Emails', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="author_password" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_author_password');
                                                                  endif; ?>><?php echo esc_html__('Author Passwords', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="post_status" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_status');
                                                               endif; ?>><?php echo esc_html__('Page Status', 'csv-importer-plus-for-acf') ?></option>
                                 <option value="comments" <?php if (isset($unique_column_names[$column_name])) : selected($column_name, 'page_comments');
                                                            endif; ?>><?php echo esc_html__('Comments (enable/disable)', 'csv-importer-plus-for-acf') ?></option>
                              </optgroup>
                           <?php endif; ?>
                           <?php //check if ACF exists
                           if (class_exists('ACF')) { ?>
                              <optgroup label="ACF Fields">
                                 <?php
                                 // Get all ACF field groups
                                 $acf_field_groups = acf_get_field_groups();

                                 $field_groups_for_post_type = array();

                                 // Filter field groups based on the selected post type
                                 foreach ($acf_field_groups as $group) {
                                    if (isset($group['location'])) {
                                       foreach ($group['location'] as $locations) {
                                          foreach ($locations as $location) {
                                             if (
                                                ($location['param'] == 'post_type' && $location['operator'] == '==' && $location['value'] == $post_type) ||
                                                ($post_type == 'page' && in_array($location['param'], array('page_template', 'page_type', 'page_parent', 'page'))) ||
                                                ($location['param'] == 'post_template') ||
                                                ($location['param'] == 'post_status') ||
                                                ($location['param'] == 'post_format') ||
                                                ($location['param'] == 'post_category') ||
                                                ($location['param'] == 'post_taxonomy') ||
                                                ($location['param'] == 'post') ||
                                                ($location['param'] == 'current_user') ||
                                                ($location['param'] == 'current_user_role') ||
                                                ($location['param'] == 'user_form') ||
                                                ($location['param'] == 'user_role') ||
                                                ($location['param'] == 'taxonomy') ||
                                                ($location['param'] == 'attachment' && $post_type == 'attachment') ||
                                                ($location['param'] == 'comment') ||
                                                ($location['param'] == 'widget') ||
                                                ($location['param'] == 'nav_menu') ||
                                                ($location['param'] == 'nav_menu_item') ||
                                                ($location['param'] == 'block') ||
                                                ($location['param'] == 'options_page')
                                             ) {
                                                $field_groups_for_post_type[] = $group;
                                                break 2; // No need to check other locations if we found a match
                                             }
                                          }
                                       }
                                    }
                                 }

                                 if (!empty($field_groups_for_post_type)) {
                                    foreach ($field_groups_for_post_type as $group) {
                                       $fields = acf_get_fields($group['key']);

                                       $free_fields = [];
                                       $pro_fields = [];

                                       if ($fields) {
                                          foreach ($fields as $field) {
                                             // Skip specific field types
                                             if (in_array($field['type'], ['message', 'tab', 'accordion', 'group', 'clone'])) {
                                                continue;
                                             }
                                             $field_type = $field['type'];
                                             $is_pro_only = false;

                                             // Check if the field type is restricted to ACF Pro
                                             switch ($field_type) {
                                                case 'file':
                                                case 'link':
                                                case 'post_object':
                                                case 'relationship':
                                                case 'flexible_content':
                                                case 'gallery':
                                                case 'repeater':
                                                case 'checkbox':
                                                case 'radio':
                                                case 'button_group':
                                                case 'wysiwyg':
                                                case 'oembed':
                                                case 'page_link':
                                                case 'taxonomy':
                                                case 'user':
                                                case 'google_map':
                                                case 'date_time_picker':
                                                case 'time_picker':
                                                case 'color_picker':
                                                case 'icon_picker':
                                                   $is_pro_only = true;
                                                   break;
                                                default:
                                                   $is_pro_only = false;
                                                   break;
                                             }

                                             // Add the field to the appropriate array
                                             if ($is_pro_only) {
                                                $pro_fields[] = $field;
                                             } else {
                                                $free_fields[] = $field;
                                             }
                                          }

                                          // Display free fields first
                                          foreach ($free_fields as $field) {
                                             echo '<option value="' . esc_attr($field['key']) . '" ' . (isset($unique_column_names[$column_name]) ? selected($column_name, $field['name'], false) : '') . '>' . esc_html(ucwords($field['label'])) . '</option>';
                                          }

                                          // Display Pro fields below with a note
                                          foreach ($pro_fields as $field) {
                                             echo '<option value="' . esc_attr($field['key']) . '" disabled style="color: #999;">' . esc_html(ucwords($field['label'])) . ' - Pro Access</option>';
                                          }
                                       } else {
                                          echo '<option disabled>No ACF fields found in group ' . esc_html($group['title']) . '</option>';
                                       }
                                    }
                                 } else {
                                    echo '<option disabled>' . esc_html__('No ACF field groups found for this post type', 'csv-importer-plus-for-acf') . '</option>';
                                 }
                                 ?>
                              </optgroup>
                           <?php } ?>
                        </select>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
      <div class="flex justify-end">
         <button type="submit" class="import-button inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-br from-blue-600 to-purple-600 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" name="import_data"><?php echo esc_html__('Import Data', 'csv-importer-plus-for-acf') ?></button>
      </div>
   </form>
</div>