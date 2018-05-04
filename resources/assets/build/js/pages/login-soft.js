var Login = function () {

  var handleLogin = function () {
    $('.login-form').validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-block', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      rules: {
        username: {
          required: true
        },
        password: {
          required: true
        },
        remember: {
          required: false
        }
      },

      messages: {
        username: {
          required: "Username is required."
        },
        password: {
          required: "Password is required."
        }
      },

      invalidHandler: function (event, validator) { //display error alert on form submit
        $('.alert-danger', $('.login-form')).show();
      },

      highlight: function (element) { // hightlight error inputs
        $(element)
          .closest('.form-group').addClass('has-error'); // set error class to the control group
      },

      success: function (label) {
        label.closest('.form-group').removeClass('has-error');
        label.remove();
      },

      errorPlacement: function (error, element) {
        error.insertAfter(element.closest('.input-icon'));
      },

      submitHandler: function (form) {
        form.submit();
      }
    });

    $('.login-form input').keypress(function (e) {
      if (e.which == 13) {
        if ($('.login-form').validate().form()) {
          $('.login-form').submit();
        }
        return false;
      }
    });
  }
  var handleSetPasswordLogin = function() {

      $('.password-form').validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-block', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          rules: {
              email: {
                  required: true,
                  email: true
              },
              password: {
                  required: true
              },
              password_confirmation: {
                  required: true,
                  equalTo: "#password"
              }
          },

          messages: {
              email: {
                  required: "Email is required."
              },
              password: {
                  required: "Password is required."
              },
              password_confirmation:{
                required: "Confirm password is required."
              }
          },

          invalidHandler: function(event, validator) { //display error alert on form submit
              $('.alert-danger', $('.password-form')).show();
          },

          highlight: function(element) { // hightlight error inputs
              $(element)
                  .closest('.form-group').addClass('has-error'); // set error class to the control group
          },

          success: function(label) {
              label.closest('.form-group').removeClass('has-error');
              label.remove();
          },

          errorPlacement: function(error, element) {
              error.insertAfter(element.closest('.input-icon'));
          },

          submitHandler: function(form) {
              form.submit(); // form validation success, call ajax form submit
          }
      });

      $('.password-form input').keypress(function(e) {
          if (e.which == 13) {
              if ($('.password-form').validate().form()) {
                  $('.password-form').submit(); //form validation success, call ajax form submit
              }
              return false;
          }
      });
  }
    var handleSetCurrentPasswordLogin = function() {

        $('.password1-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                current_password: {
                  required: true
                }
            },

            messages: {
                email: {
                    required: "Email is required."
                },
                password: {
                    required: "Password is required."
                },
                password_confirmation:{
                    required: "Confirm password is required."
                },
                current_password:{
                  required: "Current password is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit
                $('.alert-danger', $('.password1-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.password1-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.password1-form').validate().form()) {
                    $('.password1-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }
    var handleRegister1 = function() {

        $('.register1-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name:{
                  required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },

            messages: {
                name: {
                  required : "Name is required."
                },

                email: {
                    required: "Email is required."
                },
                password: {
                    required: "Password is required."
                },
                password_confirmation: {
                    required: "Confirm password is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit
                $('.alert-danger', $('.register1-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.register1-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.register1-form').validate().form()) {
                    $('.register1-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }
  var handleForgetPassword = function () {
    $('.forget-form').validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-block', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      ignore: "",
      rules: {
        email: {
          required: true,
          email: true
        }
      },

      messages: {
        email: {
          required: "Email is required."
        }
      },

      invalidHandler: function (event, validator) { //display error alert on form submit

      },

      highlight: function (element) { // hightlight error inputs
        $(element)
          .closest('.form-group').addClass('has-error'); // set error class to the control group
      },

      success: function (label) {
        label.closest('.form-group').removeClass('has-error');
        label.remove();
      },

      errorPlacement: function (error, element) {
        error.insertAfter(element.closest('.input-icon'));
      },

      submitHandler: function (form) {
        form.submit();
      }
    });


    $('.forgot-password').click(function () {

      if ($('.forget-form').validate().form()) {
        jQuery.post('/users/forgot', {
          data: {
            email: $('#email').val()
          }
        }, function (data, status) {
          if (data.status == 1) {
            $('.forgot-status').show();
            setTimeout(function () {
              $('#back-btn').trigger('click');
            }, 4000);
          }
          if (data.status == 2) {
            if(data.msg) {
              $('.forgot-status-not-found').html(data.msg);
            }
            $('.forgot-status-not-found').show();
          }
        });
      }
    });

    $('.forget-form input').keypress(function (e) {
      if (e.which == 13) {
        if ($('.forget-form').validate().form()) {
          jQuery.post('/users/forgot', {
            data: {
              email: $('#email').val()
            }
          }, function (data, status) {
            if (data.status == 1) {
              $('.forgot-status').show();
              setTimeout(function () {
                $('#back-btn').trigger('click');
              }, 4000);
            }
          });
        }
        return false;
      }
    });

    jQuery('#forget-password').click(function () {
      jQuery('.login-form').hide();
      jQuery('.forget-form').show();
    });

    jQuery('#back-btn').click(function () {
      jQuery('.login-form').show();
      jQuery('.forget-form').hide();
    });

  }

  var handleRegister = function () {

    function format(state) {
      if (!state.id) return state.text; // optgroup
      return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
    }


    $("#select2_sample4").select2({
      placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
      allowClear: true,
      formatResult: format,
      formatSelection: format,
      escapeMarkup: function (m) {
        return m;
      }
    });


    $('#select2_sample4').change(function () {
      $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
    });


    $('.register-form').validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-block', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      ignore: "",
      rules: {

        fullname: {
          required: true
        },
        email: {
          required: true,
          email: true
        },
        address: {
          required: true
        },
        city: {
          required: true
        },
        country: {
          required: true
        },

        username: {
          required: true
        },
        password: {
          required: true
        },
        rpassword: {
          equalTo: "#register_password"
        },

        tnc: {
          required: true
        }
      },

      messages: { // custom messages for radio buttons and checkboxes
        tnc: {
          required: "Please accept TNC first."
        }
      },

      invalidHandler: function (event, validator) { //display error alert on form submit

      },

      highlight: function (element) { // hightlight error inputs
        $(element)
          .closest('.form-group').addClass('has-error'); // set error class to the control group
      },

      success: function (label) {
        label.closest('.form-group').removeClass('has-error');
        label.remove();
      },

      errorPlacement: function (error, element) {
        if (element.attr("name") == "tnc") { // insert checkbox errors after the container
          error.insertAfter($('#register_tnc_error'));
        } else if (element.closest('.input-icon').size() === 1) {
          error.insertAfter(element.closest('.input-icon'));
        } else {
          error.insertAfter(element);
        }
      },

      submitHandler: function (form) {
        jQuery.post('/users/create', {
          data: {
            name: $('#name').val(),
            acc: $('.acc:checked').val(),
            email: $('#reg-email').val(),
            address: $('#address').val(),
            city: $('#city').val(),
            country: $('#country').val(),
            password: $('#password').val(),
            rpassword: $('#rpassword').val(),
            agreement: $('#agreement').val()
          }
        }, function (data, status) {
          if (data.status == 1) {
            $('.register-status').show();
            $('.register-status-error').hide();
            setTimeout(function () {
              $('#register-back-btn').trigger('click');
            }, 4000);
          } else if (data.status == 0) {
            $('.register-status').hide();
            $('.register-status-error').show();
            $('#response-messsage').html(data.message);
          }
        });
      }
    });

    $('.register-form input').keypress(function (e) {
      if (e.which == 13) {
        if ($('.register-form').validate().form()) {
          $('.register-form').submit();
        }
        return false;
      }
    });

    jQuery('#register-btn').click(function () {
      jQuery('.login-form').hide();
      jQuery('.register-form').show();
    });

    jQuery('#register-back-btn').click(function () {
      jQuery('.login-form').show();
      jQuery('.register-form').hide();
    });
  }

  return {
    //main function to initiate the module
    init: function () {

      handleLogin();
      handleForgetPassword();
      handleRegister();
      handleRegister1();
      handleSetPasswordLogin();
      handleSetCurrentPasswordLogin();
    }

  };

}();
