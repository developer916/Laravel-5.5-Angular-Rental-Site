
$(document).ready(function() {
    var current_fs, next_fs, previous_fs;
    var left, opacity, scale;
    var animating;
    var api_url = '/api/iban-check';
    var submit_url ='/api/postTenantDepositRelay';
    var next_step = 0;
    var bank_check = 0;
    $(".steps").validate({
        errorClass: 'invalid',
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.insertAfter(element.next('span').children());
        },
        highlight: function(element) {
            $(element).next('span').show();
        },
        unhighlight: function(element) {
            $(element).next('span').hide();
        }
    });
    $(".next, #landlord-next-action-button").click(function() {
        $(".steps").validate({
            errorClass: 'invalid',
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.insertAfter(element.next('span').children());
            },
            highlight: function(element) {
                $(element).next('span').show();
            },
            unhighlight: function(element) {
                $(element).next('span').hide();
            }
        });
        if ((!$('.steps').valid())) {
            return true;
        }
        if (animating) return false;
        let pagenumber = $(this).attr('data-page');  
        if(pagenumber == 9 && $('#landlord-iban').val() !='' && bank_check ==0){
         next_step = 1;
         updateContent();
        } else {
          next_step = 0;
        }
        if(next_step == 0) {
            animating = true;
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            next_fs.show();
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now, mx) {
                    scale = 1 - (1 - now) * 0.2;
                    left = (now * 50) + "%";
                    opacity = 1 - now;
                    current_fs.css({
                        // 'transform': 'scale(' + scale + ')'
                    });
                    next_fs.css({
                        'left': left,
                        'opacity': opacity
                    });
                },
                duration: 800,
                complete: function() {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutExpo'
            });
        }
    });
    $(".submit").click(function() {
        $(".steps").validate({
            errorClass: 'invalid',
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.insertAfter(element.next('span').children());
            },
            highlight: function(element) {
                $(element).next('span').show();
            },
            unhighlight: function(element) {
                $(element).next('span').hide();
            }
        });
        if ((!$('.steps').valid())) {
            return false;
        }
        if (animating) return false;
        animating = true;
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
	    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        next_fs.show();
	    sendSubmitContent();
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                scale = 1 - (1 - now) * 0.2;
                left = (now * 50) + "%";
                opacity = 1 - now;
                current_fs.css({
                    // 'transform': 'scale(' + scale + ')'
                });
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            easing: 'easeInOutExpo'
        });
    });
    $(".previous").click(function() {
        if (animating) return false;
        animating = true;
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        previous_fs.show();
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                scale = 0.8 + (1 - now) * 0.2;
                left = ((1 - now) * 50) + "%";
                opacity = 1 - now;
                current_fs.css({
                    'left': left
                });
                previous_fs.css({
                    // 'transform': 'scale(' + scale + ')',
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            easing: 'easeInOutExpo'
        });
    });

    $('form.steps').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4'
    });
    // display review page
    $('#review-next-action-button').click(function() {     
	$("#progressbar").css('visibility', 'hidden');                
        $('#review-content').html('');
        $('fieldset').each(function(index) {
            let pageNum = $(this).find('.action-button').attr('data-page');            
            if(pageNum != 1 && pageNum != 14) {
                let strHtml = '<div class="field-title">' + (pageNum) + '. ' + titles[pageNum-1];
                strHtml += '<span class="pagelink" page-num="' + pageNum + '">&nbsp;&nbsp;[Edit]</span>';
                strHtml +=  '</div>';
                if(pageNum == 2 || pageNum == 3) {      // agreement page                    
                    strHtml += '<div class="field-content">';                                                     
                    strHtml += $(this).find('input[type="checkbox"]').prop('checked') ? 'Accepted':'';
                    strHtml += '</div>'; 
                } else if(pageNum == 4) {       // address page
                    let values = '';
                    $(this).find('input').each(function(idx) {                        
                        if(idx == 0 || $(this).attr('type') == 'button') return;
                        if(values == '') values += $(this).val();
                        else values += ', ' + $(this).val();                        
                    })
                    strHtml += '<div class="field-content">' + values + '</div>'; 
                } else {
                    let values = '';
                    $(this).find('input').each(function(idx) { 
                        if($(this).attr('type') == 'button') return;                                               
                        if(values == '') values += $(this).val();
                        else values += ', ' + $(this).val();                        
                    })
                    strHtml += '<div class="field-content">' + values + '</div>'; 
                }                               
                $('#review-content').append(strHtml);
            }
        })

        $('span.pagelink').unbind('click').bind('click', pagelinkClkEvt);
    });
    // gp back to form page
    $('.backform.action-button').click(function() {        
        $("#progressbar").css('visibility', 'visible');        
    });

    $('#datepicker').on('change', function() {
        console.log('change');
        if($(this).val() != "") $('.next[data-page="5"]').attr("disabled", false);
    })
	
    function updateContent(){
         $.ajax({
            type:"POST",
            url:api_url,
            data: {iban : $('#landlord-iban').val()},
            success: function(data) {
                if(data == '') {
                    alert("This iban is incorrect. Please check it again.");
                     return;
                }else {
                    next_step = 0;
                    bank_check = 1;
                    $("#landlord-next-action-button").trigger("click");
                }
             }
         });
	}
    function sendSubmitContent() {
        $.ajax({
            type:"POST",
            url:submit_url,
            data: $("#TenantDepositRelayForm").serialize(),
            success: function(data) {
                if(data == 'success') {
                    window.location.href = 'https://www.rentling.group/fty';
                }
             }
        });
    }
    
    function pagelinkClkEvt() {
        console.log('go to page');
        let pageNum = $(this).attr('page-num');
        console.log(pageNum);
        current_fs = $(this).closest('fieldset');
        next_fs = $('input[data-page="' + pageNum + '"]').closest('fieldset');
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        current_fs.css("display", "none");
        // next_fs.css({"display":"block", "left":"unset", "opacity": "unset", "transform": "unset"});
        next_fs.show();
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                // scale = 1 - (1 - now) * 0.2;
                console.log('now');
                console.log(now);
                console.log('scale');
                console.log(scale);
                left = (now * 50) + "%";
                opacity = 1 - now;
                current_fs.css({
                    // 'transform': 'scale(' + scale + ')'
                });
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            easing: 'easeInOutExpo'
        });
    }
});
var titles = ['','Please read our terms and conditions','Please also agree to our privacy policy',
    'Address you will rent','Your move in date','Landlord name','Landlord Email',
    'Landlord mobile phone nr','Landlord IBAN','Deposit amount','Your name','Your Email','Your mobile phone nr'
];
    var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        console.log('initAutocomplete');
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        console.log("fill address");
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }

        $('.next[data-page="4"]').attr("disabled", false);
        $('.address-detail').fadeIn();       

      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        console.log("geolocate");
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }


    
        
    
