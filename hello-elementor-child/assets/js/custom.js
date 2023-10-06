(function ($) {
    $("#menu-mobile-menu li a").on("click", function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().parent().parent().find(".elementor-active").removeClass("elementor-active");
        // console.log($(this).text());
        // $("body").css({ overflow: "hidden" });
        // $("body").find("#checkout-login-modal").css({
        //     display: "block",
        // });
    });

    /* NEW WORK */
    // Login Functionality
    $('#loginform').on('submit', function(e){
        e.preventDefault();
        // $(this).find('.pop-loader-image').show();
        // $(this).find('#wp-submit').prop('disabled', true);
        email = $(this).find('#user_email').val();
        pass = $(this).find('#user_pass').val();
        redirect_to = $(this).find('#redirect_to').val();
        remember = $(this).find('#checkboxG5').prop('checked');
        dataOfUser = {
            "email": $.trim(email),
            "pass": $.trim(pass),
            'rememberme': $.trim(remember),
            "action": "user_login",
        };
        $.ajax({
            url: my_ajax_object.ajax_url,
            data: dataOfUser,
            method: "POST"
        }).done(function(responseText, data) {
            result = $.trim(responseText);
            if(result == 'passNotFound') {
                // bootbox.alert({
                //     title: "Invalid credentials!",
                //     message: "Password is incorrect! Please Try again.",
                // });
                alert("Password is incorrect! Please Try again")
                return;   
            }else if(result == 'emailNotFound') {
                // bootbox.alert({
                //     title: "Invalid credentials!",
                //     message: "Email is incorrect! Please Try again.",
                // });
                alert("Email is incorrect! Please Try again.")
                return;
            }else{
                updatedData = jQuery.parseJSON(result);
                window.location = redirect_to;
                // console.log("Login Successfully")
                // $('.login-anchor').html('<img src="'+updatedData['img']+'" class="login-image-profile"> My Account ');
                // $('.global-login-anchor .dl-donate-txt').html(' My Account ');
                // $('#Donation360 #gnDonateBtn').removeClass('not-user');
                // $('#Donation360 #gnDonateBtn').addClass('is-user');
                // $('#Donation360 #gnDonateBtn').next().removeClass('is-user');
                // $('#Donation360 #gnDonateBtn').next().addClass('not-user');
                // if( (generalDonation == true) && (specificDonation == false) && (suggestedAmount == false) ){
                //     $('#login-modal').modal('hide');
                //     $('#Donation360').modal('hide');
                //     $('.general-donation-not-logged-in').prev().click();
                //     return;
                // }
                // if( (generalDonation == false) && (specificDonation == true) && (suggestedAmount == false) ){
                //     $('#login-modal').modal('hide');
                //     $('#charitable-donation-form-modal-loop').hide();
                //     $('div#charitable-donation-form-modal-loop').removeClass('container-hide');
                //     $('div#lean_overlay').removeClass('container-hide');
                //     currentSelectedCampaign[0].click();
                //     return;
                // }
                // if( (generalDonation == false) && (specificDonation == false) && (suggestedAmount == true) ){
                //     $('#login-modal').modal('hide');
                //     $('.single-campaign-button-div .single-campaign-donation-button:first-child').removeClass('not-user');
                //     $('.single-campaign-button-div .single-campaign-donation-button:first-child').addClass('is-user');
                //     $('.single-campaign-button-div .single-campaign-donation-button:last-child').addClass('not-user');
                //     $('.single-campaign-button-div .single-campaign-donation-button:last-child').removeClass('is-user');
                //     lastSuggestedAmountSelected.click();
                //     return;
                // }
            }
         });
        $(this).ajaxComplete(function(){
            $(this).find('.pop-loader-image').hide();
            $(this).find('#wp-submit').removeAttr('disabled');
        });
    });

    // Registeration Functionality
    $('#user-register-form-submit').on('click', function(e){
        //$(this).prop('disabled', true);
        //$('#register-modal .register-user-button .image-loader').show();
        e.preventDefault();
        first_name = $('#signupform #first_name').val();
        last_name = $('#signupform #last_name').val();
        email = $('#signupform #email').val();
        country = $('#signupform #country').val();
        user_password = $('#signupform #user_password').val();
        user_c_password = $('#signupform #user_c_password').val();
        emailValidation = validateEmail(email);
       
        if( ( (first_name == '') || (last_name == '') || (email == '') || (country == "Select country" ) || (user_password == '') || (user_c_password == '') ) ){
            // $('#register-modal .register-user-button').removeAttr("disabled");
            // $('#register-modal .register-user-button .image-loader').hide();
            // bootbox.alert({
            //     size: "small",
            //     title: "Empty credentials",
            //     message: "Please fill all the fields!",
            // });
            alert("Please fill all the fields!")
            return;
        }else if (!emailValidation){
            // $('#register-modal .register-user-button').removeAttr("disabled");
            // $('#register-modal .register-user-button .image-loader').hide();
            // bootbox.alert({
            //     size: "small",
            //     title: "Invalid Email",
            //     message: "Please enter valid Email address!",
            // });
            alert("Please enter valid Email address!")
            return;
        }else if( (user_password != user_c_password) ){
            // $('#register-modal .register-user-button').removeAttr("disabled");
            // $('#register-modal .register-user-button .image-loader').hide();
            // bootbox.alert({
            //     size: "small",
            //     title: "Password not matched!",
            //     message: "Password and confirm password doesn't match. Try again!",
            // });
            alert("Password and confirm password doesn't match. Try again!")
            return;
        }else if( (user_password.length <= 6) || (user_c_password.length <= 6) ){
            $('#register-modal .register-user-button').removeAttr("disabled");
            $('#register-modal .register-user-button .image-loader').hide();
            // bootbox.alert({
            //     size: "small",
            //     title: "Password length too short!",
            //     message: "Password and confirm password should be greater than 6 letters!",
            // });
            alert("Password and confirm password should be greater than 6 letters!")
            return;
        }else{      
            dataOfUser = {
                "first_name": $.trim(first_name),
                "last_name": $.trim(last_name),
                "email": $.trim(email),
                "country": $.trim(country),
                "user_password": $.trim(user_password),
                "action": "user_registeration",
            };
            //console.log(dataOfUser);
            $.ajax({
                // url: ajax_url,
                url: my_ajax_object.ajax_url,
                data: dataOfUser,
                method: "POST"
            }).done(function(responseText, data){
                result = $.trim(responseText);
                //console.log(result)
                updatedData = jQuery.parseJSON(result);
                if(updatedData['result'] == 'user-logged-in'){
                    // $('.login-anchor').html(' My Account ');
                    // $('#Donation360 #gnDonateBtn').removeClass('not-user');
                    // $('#Donation360 #gnDonateBtn').addClass('is-user');
                    // $('#Donation360 #gnDonateBtn').next().removeClass('is-user');
                    // $('#Donation360 #gnDonateBtn').next().addClass('not-user');
                    // if( (generalDonation == true) && (specificDonation == false) && (suggestedAmount == false) ){
                    //     $('#login-modal').modal('hide');
                    //     $('#Donation360').modal('hide');
                    //     $('#register-modal').modal('hide');
                    //     $('.general-donation-not-logged-in').prev().click();
                    //     return;
                    // }
                    // if( (generalDonation == false) && (specificDonation == true) && (suggestedAmount == false) ){
                    //     $('#register-modal').modal('hide');
                    //     $('#login-modal').modal('hide');
                    //     $('#charitable-donation-form-modal-loop').hide();
                    //     $('div#charitable-donation-form-modal-loop').removeClass('container-hide');
                    //     $('div#lean_overlay').removeClass('container-hide');
                    //     currentSelectedCampaign[0].click();
                    //     return;
                    // }
                    // if( (generalDonation == false) && (specificDonation == false) && (suggestedAmount == true) ){
                    //     $('#login-modal').modal('hide');
                    //     $('#register-modal').modal('hide');
                    //     $('.single-campaign-button-div .single-campaign-donation-button:first-child').removeClass('not-user');
                    //     $('.single-campaign-button-div .single-campaign-donation-button:first-child').addClass('is-user');
                    //     $('.single-campaign-button-div .single-campaign-donation-button:last-child').addClass('not-user');
                    //     $('.single-campaign-button-div .single-campaign-donation-button:last-child').removeClass('is-user');
                    //     lastSuggestedAmountSelected.click();
                    //     return;
                    // }
                }else if (updatedData['result'] == 'user-email-already-available'){
                    // $('#register-modal .register-user-button').removeAttr("disabled");
                    // $('#register-modal .register-user-button .image-loader').hide();
                    // bootbox.alert({
                    //     size: "small",
                    //     title: "Invalid email!",
                    //     message: "This Email is already registered! try another one",
                    // });
                    alert("This Email is already registered! try another one")
                }
            }).fail(function(error){
                console.log('error creating user');
            });
        }
    });

    function validateEmail($email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test( $email );
    }

    // Password Toggle Functionality
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
          var input = $('#loginform').find('#user_pass');
          if (input.attr("type") == "password") {
            input.attr("type", "text");
          } else {
            input.attr("type", "password");
          }
    });

    // ISLAMIC THEME WORK

    // Find the element with specified classes
    var socialIconsWrapper = $('.topHeader .elementor-social-icons-wrapper.elementor-grid');
    // Create an h3 element
    var heading = $('<h3>').text('Follow us:');
    // Append the h3 element to the found element
    socialIconsWrapper.prepend(heading);

    $('.prayer-timing-button-container button').click(function() {
        console.log("WORK")
        $('.prayer-table').toggleClass('show-table');
    });

})(jQuery);
