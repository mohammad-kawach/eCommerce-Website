$(function () {
  "use strict";

  $('.toggle-orders').on("click",function() {
		$(this).toggleClass('selected');
		if ($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
      $('.panel-body-orders').fadeOut();
		} else {
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
      $('.panel-body-orders').fadeIn();
		}
  }); 

  $('.toggle-items').on("click",function() {
		$(this).toggleClass('selected');
		if ($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
      $('.panel-body-items').fadeOut();
		} else {
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
      $('.panel-body-items').fadeIn();
		}
  }); 

  $('.toggle-comments').on("click",function() {
		$(this).toggleClass('selected');
		if ($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
      $('.panel-body-comments').fadeOut();
		} else {
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
      $('.panel-body-comments').fadeIn();
		}
  }); 

  /*$('.toggle-info').on("click",function() {
    console.log('.toggle-info');
		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
		if ($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		} else {
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
		}
	});*/

  // Display The Small Rectangle (that  is above the notifications) when clicking on notifications button
  // i didn't use :before because it disappeared when i used (overflow-y: scroll)
  var notificationsClickCount = 0;

  $(".btn-notifications").on("click",function(){
    ++notificationsClickCount;
    console.log(notificationsClickCount);
    if (notificationsClickCount % 2 == 1) {
      $(".notis-rect").css("display","block");
    } else if (notificationsClickCount % 2 == 0 && notificationsClickCount != 0) {
      $(".notis-rect").css("display","none");
    }
  });

  // Switch Between Login & Signup
  $(".login-page h1 span").click(function () {
    $(this).addClass("selected").siblings().removeClass("selected");
    $(".login-page form").hide();
    $("." + $(this).data("class")).fadeIn(100);
  });

  // Trigger The Selectboxit
  $("select").selectBoxIt({
    autoWidth: false,
  });

  // Hide Placeholder On Form Focus
  $("[placeholder]")
    .focus(function () {
      $(this).attr("data-text", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function () {
      $(this).attr("placeholder", $(this).attr("data-text"));
    });

  // Add Asterisk On Required Field
  $("input").each(function () {
    if ($(this).attr("required") === "required") {
      $(this).after('<span class="asterisk">*</span>');
    }

    if ($(this).attr("data-info") == "payment") {
      $(this).after('<span styyle="display: none;" class="asterisk">*</span>');
    }
  });
  

  // Confirmation Message On Button
  $(".confirm").click(function () {
    return confirm("Are You Sure?");
  });

  $(".live").keyup(function () {
    $($(this).data("class")).text($(this).val());
  });

  /* Start Contact Us Page */
  var userError = true,
    emailError = true,
    msgError = true;

  $(".username").blur(function () {
    if ($(this).val().length < 4) {
      // Show Error
      $(this)
        .css("border", "1px solid #F00")
        .parent()
        .find(".custom-alert")
        .fadeIn(200)
        .end()
        .find(".asterisx")
        .fadeIn(100);

      userError = true;
    } else {
      // No Errors
      $(this)
        .css("border", "1px solid #080")
        .parent()
        .find(".custom-alert")
        .fadeOut(200)
        .end()
        .find(".asterisx")
        .fadeOut(100);
      userError = false;
    }
  });

  $(".email").blur(function () {
    if ($(this).val() === "") {
      $(this)
        .css("border", "1px solid #F00")
        .parent()
        .find(".custom-alert")
        .fadeIn(200)
        .end()
        .find(".asterisx")
        .fadeIn(100);

      emailError = true;
    } else {
      $(this)
        .css("border", "1px solid #080")
        .parent()
        .find(".custom-alert")
        .fadeOut(200)
        .end()
        .find(".asterisx")
        .fadeOut(100);

      emailError = false;
    }
  });

  $(".message").blur(function () {
    if ($(this).val().length < 10) {
      $(this)
        .css("border", "1px solid #F00")
        .parent()
        .find(".custom-alert")
        .fadeIn(200)
        .end()
        .find(".asterisx")
        .fadeIn(100);

      msgError = true;
    } else {
      $(this)
        .css("border", "1px solid #080")
        .parent()
        .find(".custom-alert")
        .fadeOut(200)
        .end()
        .find(".asterisx")
        .fadeOut(100);

      msgError = false;
    }
  });

  // Submit Form Validation
  $(".contact-form").submit(function (e) {
    if (userError === true || emailError === true || msgError === true) {
      e.preventDefault();
      $(".username, .email, .message").blur();
    }
  });
  /* End Contact Us Page */

  /* Start Limit Upload Images */
  /*$(function () {
    $("input[type = 'submit']").click(function () {
      var $fileUpload = $(".all-images");
      if (parseInt($fileUpload.get(0).files.length) > 6) {
        alert("You are only allowed to upload a maximum of 6 files");
      }
    });
  });*/

  $("#image").on("change", function() {
    if ($("#image")[0].files.length > 2) {
        alert("You can select only 2 images");
    } else {
        $("#imageUploadForm").submit();
    }
  });
  /* End Limit Upload Images */

  $(document).on('click','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') ) {
        $(this).collapse('hide');
    }
  });


  /* ----------------------------------------------------------------------------------- */
  /*$('.toggle-info').on("click",function() {
    console.log('.toggle-info');
		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
		if ($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		} else {
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
		}
	});*/

  
  /* ----------------------------------------------------------------------------------- */
});
