<?php

/**
 * @package CsvImporterPlusforACF
 * CSV ACF Importer Form Template
 */
?>

<?php

// make sure we don't expose any info if called directly
if (!defined('ABSPATH')) exit; // Exit if accessed directly

?>

<div class="p-10">
   <div class="relative max-w-5xl mx-auto">
      <div class="max-w-lg mx-auto rounded-lg shadow-lg overflow-hidden lg:max-w-none lg:flex">
         <div class="flex-1 px-6 py-8 lg:p-12 bg-white">
            <h3 class="text-2xl font-extrabold sm:text-3xl"><?php echo esc_html__('Lifetime Access', 'csv-importer-plus-for-acf') ?></h3>
            <p class="mt-6 text-base sm:text-lg"><?php echo esc_html__('Unlock even more with the premium version, featuring advanced ACF fields listed below. Enhance your workflow and gain access to exclusive features tailored for professionals.', 'csv-importer-plus-for-acf') ?></p>
            <div class="mt-8">
               <div class="flex items-center">
                  <div class="flex-1 border-t-2 border-gray-200"></div>
               </div>
               <ul role="list" class="mt-8 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8 lg:gap-y-5">
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('File', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Link', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Post Object', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Relationship', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Gallery', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Checkbox', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Radio Button', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('WYSIWYG Editor', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('oEmbed', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Page Link', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Taxonomy', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('User', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Google Map', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Date Time Picker', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Time Picker', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Color Picker', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Icon Picker', 'csv-importer-plus-for-acf') ?></p>
                  </li>
                  <li class="flex items-start lg:col-span-1">
                     <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg></div>
                     <p class="ml-3"><?php echo esc_html__('Flexible Content', 'csv-importer-plus-for-acf') ?></p>
                  </li>
               </ul>
            </div>
         </div>
         <div class="py-8 px-6 text-center lg:flex-shrink-0 lg:flex lg:flex-col lg:justify-center lg:p-12 bg-gradient-to-br from-blue-600 to-purple-600">
            <p class="text-lg leading-6 font-medium text-white"><?php echo esc_html__('Pay once, own it forever', 'csv-importer-plus-for-acf') ?></p>
            <div class="mt-4 flex items-center justify-center text-5xl font-extrabold text-white">
               <span><?php echo esc_html__('$49.99', 'csv-importer-plus-for-acf') ?></span><span class="ml-3 text-xl font-medium text-gray-50"><?php echo esc_html__('USD', 'csv-importer-plus-for-acf') ?></span>
            </div>
            <div class="mt-6">
               <div class="rounded-md shadow">
                  <a href="<?php echo esc_url('https://bestropro.com/'); ?>" class="flex items-center justify-center px-5 py-3 border border-transparent  font-extrabold rounded-md text-black transition-transform transform-gpu hover:-translate-y-1 hover:shadow-lg hover:text-white text-lg buy-now" target="_blank"><?php echo esc_html__('Upgrade To Pro', 'csv-importer-plus-for-acf') ?></a>
               </div>
               <p class="text-gray-300 text-sm mt-3"><?php echo esc_html__('Dedicated Support for Premium Users', 'csv-importer-plus-for-acf') ?></p>
            </div>
         </div>
      </div>
   </div>
</div>