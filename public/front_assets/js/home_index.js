function refreshWishlist() {
  var baseUrl =
    $('meta[name="base-url"]').attr("content") || window.location.origin;
  var refreshUrl = baseUrl + "/get-updated-wishlist";

  $.ajax({
    type: "GET",
    url: refreshUrl,
    cache: false,
    success: function (response) {
      if (response.success) {
        var dropdownContent = "";
        if (response.wishlist.length > 0) {
          response.wishlist.slice(0, 4).forEach(function (item) {
            dropdownContent += `
                          <a class="dropdown-item d-flex align-items-center" href="/allwishlist">
                              <div class="dropdown-list-image mr-3">
                                  <img class="rounded-circle" src="${
                                    item.profile_image
                                  }" alt="...">
                                  <div class="${
                                    item.online_status == 1
                                      ? "status-indicator bg-success"
                                      : ""
                                  }"></div>
                              </div>
                              <div>
                                  <div class="text-truncate">${
                                    item.first_name
                                  }</div>
                                  <div class="small text-gray-500">Emily Fowler · 58m</div>
                              </div>
                          </a>
                      `;
          });
          dropdownContent += `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">Read More Wishlist</a>`;
        } else {
          dropdownContent = `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>`;
        }

        $(".chatnoti-open").html(`
                  <h6 class="dropdown-header">Wishlist</h6>
                  ${dropdownContent}
              `);
      } else {
        // Handle case where response.success is false
        $(".chatnoti-open").html(`
                  <h6 class="dropdown-header">Wishlist</h6>
                  <a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>
              `);
      }
    },
    error: function () {
      console.error("Failed to refresh the wishlist.");
    },
  });
}

function fetchFilteredResults_slider(startPrice = false, endPrice = false) {
  // Get the selected values
  const subjectValue = $("#subject-select").val();
  const nameValue = $("#name-select").val();
  const languageValue = $("#language-select").val();
  const priceValue = $("#price-select-relevance").val();
  const keywordTextValue = $("#keyword-text").val();

  const startPriceValue = startPrice;
  const endPriceValue = endPrice;

  // Show the loading spinner
  //$('#loading-spinner').show();
  $("#results-container").html(
    "<div class='text-center'><img src='{{ asset('public/admin/assets/images/lg.gif') }}' alt='Loading...'></div>"
  );
  // Make AJAX request to fetch filtered results
  $.ajax({
    url: "{{ route('gururesults') }}", // Laravel route for loading results
    method: "POST",
    data: {
      _token: "{{ csrf_token() }}", // CSRF token for security
      subject: subjectValue,
      name: nameValue,
      language: languageValue,
      price: priceValue,
      keyword: keywordTextValue,
      startprice: startPriceValue,
      endprice: endPriceValue,
    },
    success: function (response) {
      // Update the results container with the new data
      $("#results-container").html(response);

      const ulElement = $("#results-container ul");
      if (ulElement.find("li").length === 0) {
        $("#results-container").html(
          "<p class='text-center no-data-text'>No data found</p>"
        );
      }

      initializePagination();
      initializeHoverEffect();
      stopvideo_autoplay();
    },
    error: function () {
      alert("An error occurred while fetching results.");
    },
    complete: function () {
      // Hide the loading spinner once the request is complete
      //$('#loading-spinner').hide();
    },
  });
}

function stopvideo_autoplay() {
  $(".video-player").hover(
    function () {
      // Show controls only if the video is paused and the user is hovering
      if ($(this)[0].paused) {
        $(this)
          .siblings(".play-button-wrapper")
          .find(".play_button")
          .show()
          .prop("disabled", false); // Enable the play button when hovering and paused
      }
      $(this).attr("controls", "controls"); // Add controls on hover
    },
    function () {
      if ($(this)[0].paused) {
        $(this).removeAttr("controls"); // Remove controls if video is paused and not hovered
        $(this)
          .siblings(".play-button-wrapper")
          .find(".play_button")
          .show()
          .prop("disabled", false); // Enable the play button when not hovering and paused
      }
    }
  );

  // Handle the play button click
  $(".play_button").click(function () {
    var video = $(this)
      .closest(".play-button-wrapper")
      .siblings(".video-player")[0];
    video.play(); // Start the video
    $(this).hide(); // Hide the play button
    $(video).attr("controls", "controls"); // Ensure controls are visible during playback
    $(this).prop("disabled", true); // Disable the play button when the video is playing
  });

  // Handle clicking directly on the video
  $(".video-player").click(function () {
    if (this.paused) {
      this.play(); // Start the video
      $(this).siblings(".play-button-wrapper").find(".play_button").hide(); // Hide the play button when playing
      $(this).attr("controls", "controls"); // Ensure controls are visible during playback
    } else {
      this.pause(); // Pause the video
      $(this).siblings(".play-button-wrapper").find(".play_button").show(); // Show the play button when paused
    }
  });

  // Hide and disable the play button when the video starts playing
  $(".video-player").on("play", function () {
    $(this)
      .siblings(".play-button-wrapper")
      .find(".play_button")
      .hide()
      .prop("disabled", true); // Disable and hide play button when video starts playing
  });

  // Show and enable the play button when the video is paused
  $(".video-player").on("pause", function () {
    $(this)
      .siblings(".play-button-wrapper")
      .find(".play_button")
      .show()
      .prop("disabled", false); // Enable and show play button when video is paused
  });
}
