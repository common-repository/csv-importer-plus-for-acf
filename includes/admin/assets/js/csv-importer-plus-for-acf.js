jQuery(document).ready(function ($) {
  $(".toplevel_page_csv_importer_plus_for_acf #mapping-form").on(
    "submit",
    function (event) {
      event.preventDefault();

      // Hide mapping form and show status messages
      $(
        ".toplevel_page_csv_importer_plus_for_acf #importer-form-container"
      ).hide();
      $(".toplevel_page_csv_importer_plus_for_acf #status-messages").show();

      var statusContainer = $("#status-messages");
      var formData = $(this).serialize();

      function processChunk(currentChunk) {
        $.ajax({
          url: ajaxurl,
          type: "POST",
          data: formData + "&current_chunk=" + currentChunk,
          dataType: "json",
          success: function (response) {
            if (response.success) {
              var totalChunks = response.data.total_chunks;
              var percentage =
                (response.data.current_chunk / totalChunks) * 100;
              var percentageInt = parseInt(percentage, 10);
              // Update progress bar and text
              $(".toplevel_page_csv_importer_plus_for_acf #progress-bar").css(
                "width",
                percentageInt + "%"
              );
              $(".toplevel_page_csv_importer_plus_for_acf #progress-text").text(
                percentageInt + "%"
              );
              // Trigger custom event for additional handling
              $(document).trigger("cipfa_chunk_processed_ajax", [percentage]);

              // Process the next chunk
              if (response.data.current_chunk < totalChunks) {
                processChunk(response.data.current_chunk);
              } else {
                var logContent = "";
                if (response.data.logs && response.data.logs.length > 0) {
                  logContent =
                    '<strong class="block pt-4 pb-4 text-black text-lg">Log</strong>' +
                    '<div id="view-log-container" class="overflow-y-auto max-h-64 p-4 bg-grey border border-gray-300 rounded">' +
                    response.data.logs +
                    "</div>";
                }
                statusContainer.html(
                  '<div class="text-green-700 text-lg"><strong class="block mb-2">Success!</strong><p>' +
                    response.data.message +
                    "</p>" +
                    logContent +
                    "</div>"
                );
              }
            } else {
              // Handle error
              console.log("Error: ", response);
            }
          },
          error: function (xhr, status, error) {
            // Handle error
            console.log(xhr.responseText);
          },
        });
      }
      // Start processing chunks from the first one
      processChunk(0);
    }
  );
  $(document).on("cipfa_chunk_processed_ajax", function (event, percentageInt) {
    // Round to one decimal place
    var roundedPercentage = parseFloat(percentageInt).toFixed(1);
    // Update progress bar width
    $(".toplevel_page_csv_importer_plus_for_acf #progress-bar").css(
      "width",
      roundedPercentage + "%"
    );
    $(".toplevel_page_csv_importer_plus_for_acf #progress-text").text(
      roundedPercentage + "%"
    );
  });
  $(".toplevel_page_csv_importer_plus_for_acf #csv-upload-form").on(
    "submit",
    function (event) {
      var fileInput = $("#csv-file");
      var file = fileInput.val();

      // Check if file input is empty
      if (file === "") {
        alert("Please upload a CSV file.");
        event.preventDefault(); // Prevent form submission
        return false;
      }

      // Additional check to ensure the file is a CSV
      var fileType = fileInput.prop("files")[0].type;
      if (fileType !== "text/csv" && !file.endsWith(".csv")) {
        alert("Please upload a valid CSV file.");
        event.preventDefault(); // Prevent form submission
        return false;
      }
    }
  );
});
