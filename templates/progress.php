<?php

/**
 * @package CsvImporterPlusforACF
 * Progress & Logs
 */

?>

<?php

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

?>

<!-- Progress bar & logs -->
<div id="status-messages" class="max-w-3xl mx-auto mt-8 p-8 bg-white rounded-lg shadow-lg" style="display: none">
   <div class="w-full bg-gray-200 rounded-lg h-4">
      <div id="progress-bar" class="bg-blue-500 h-4 rounded-lg" style="width: 0%;"></div>
   </div>
   <div id="progress-text" class="text-center mt-2 text-gray-700">0%</div>
   <div id="view-log-container"></div>
</div>