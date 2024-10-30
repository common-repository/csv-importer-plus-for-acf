<?php

/**
 * @package CsvImporterPlusforACF
 * CSV Upload Form
 */
?>

<?php

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Get all registered post types
$post_types = get_post_types(array('public' => true), 'objects');
// Filter post types based on the conditions
$filtered_post_types = array_filter($post_types, function ($post_type) {
   return (!$post_type->show_ui ||
      !$post_type->show_in_nav_menus ||
      !$post_type->query_var ||
      !post_type_supports($post_type->name, 'editor')
      && $post_type->capability_type == 'post'
   );
});
?>

<!-- Display import form -->
<div class="max-w-3xl mx-auto mt-28 p-8 bg-white rounded-lg shadow-lg">
   <h2 class="text-2xl mb-8 text-center font-semibold"><?php echo esc_html__('CSV Importer Plus for ACF', 'csv-importer-plus-for-acf') ?></h2>
   <form method="post" enctype="multipart/form-data" class="flex flex-col" id="csv-upload-form">
      <div class="mb-4 flex items-center">
         <label for="post_type_select" class="block text-sm font-semibold text-gray-600 mr-16"><?php echo esc_html__('Post Type:', 'csv-importer-plus-for-acf') ?></label>
         <select name="post_type" id="post_type_select" class="block w-1/2 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
            <?php foreach ($filtered_post_types as $post_type) : ?>
               <?php if ($post_type->name !== 'attachment') : ?>
                  <option value="<?php echo esc_attr($post_type->name); ?>"><?php echo esc_html($post_type->label); ?></option>
               <?php endif; ?>
            <?php endforeach; ?>
         </select>
      </div>
      <div class="mb-4 flex items-center">
         <label for="chunk-size" class="block text-sm font-semibold text-gray-600 mr-14"><?php echo esc_html__('Chunk Size:', 'csv-importer-plus-for-acf') ?></label>
         <select id="chunk-size" name="chunk_size" class="block  p-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500">
            <option value="<?php echo esc_attr(10); ?>"><?php echo esc_html__('10', 'csv-importer-plus-for-acf') ?></option>
            <option value="<?php echo esc_attr(20); ?>"><?php echo esc_html__('20', 'csv-importer-plus-for-acf') ?></option>
            <option value="<?php echo esc_attr(30); ?>"><?php echo esc_html__('30', 'csv-importer-plus-for-acf') ?></option>
            <option value="<?php echo esc_attr(40); ?>"><?php echo esc_html__('40', 'csv-importer-plus-for-acf') ?></option>
            <option value="<?php echo esc_attr(50); ?>"><?php echo esc_html__('50', 'csv-importer-plus-for-acf') ?></option>
            <option value="<?php echo esc_attr(60); ?>"><?php echo esc_html__('60', 'csv-importer-plus-for-acf') ?></option>
            <option value="<?php echo esc_attr(70); ?>"><?php echo esc_html__('70', 'csv-importer-plus-for-acf') ?></option>
            <option value="<?php echo esc_attr(80); ?>"><?php echo esc_html__('80', 'csv-importer-plus-for-acf') ?></option>
            <option value="<?php echo esc_attr(90); ?>"><?php echo esc_html__('90', 'csv-importer-plus-for-acf') ?></option>
            <option value="<?php echo esc_attr(100); ?>"><?php echo esc_html__('100', 'csv-importer-plus-for-acf') ?></option>
         </select>
      </div>
      <div class="mb-6 flex items-center">
         <label for="csv_file" class="block text-sm font-semibold text-gray-600 mr-6"><?php echo esc_html__('Upload CSV File:', 'csv-importer-plus-for-acf') ?></label>
         <input type="file" name="csv_file" id="csv-file" accept=".csv" />
      </div>
      <?php wp_nonce_field('cipfa_nonce', 'cipfa_nonce_field'); ?>
      <input type="hidden" name="step" value="2">
      <div class="mb-4 flex items-center">
         <label for="edit_existing" class="block text-sm font-semibold text-gray-600 mr-20"><?php echo esc_html__('Update', 'csv-importer-plus-for-acf') ?></label>
         <input type="checkbox" id="edit_existing" name="edit_existing" value="<?php echo esc_attr(1); ?>" class="mr-2">
         <span class="text-xs text-gray-500"><?php echo esc_html__('Check only to update existing posts/pages. Must include post ID column in CSV.', 'csv-importer-plus-for-acf') ?></span>
      </div>
      <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent font-medium rounded-md text-white bg-gradient-to-br from-blue-600 to-purple-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 self-end text-lg" name="next"><?php echo esc_html__('Next', 'csv-importer-plus-for-acf') ?></button>

   </form>
</div>