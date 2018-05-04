var countDiv = 0 ;
var editDiv =0;
var editRowNumber;
var foundTenant = 0;
var api_url = '/existTenants';
var submit_url ='/postNewUserWizard';
$(document).ready(function() {
    var current_fs, next_fs, previous_fs;
    var left, opacity, scale;
    var animating;
    var next_step = 0;
    var tenant_check = 0;
    var next_step_review = 0;
    var tenant_address_check = 0;
    if($("#existUser").val() == 1 && $('input[name=select-type]:checked').val() == 'landlord'){
        countDiv = 1;
    }
    $('.datepicker-start-date').datepicker({
        uiLibrary: 'bootstrap4'
    });

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
    $(".next, #next-landlord-action-button-step").click(function() {
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
        var selected_type = $('input[name=select-type]:checked').val();
        var existUser = $("#existUser").val();
        if(pagenumber == 3 && selected_type =='landlord' && tenant_check == 0){
            next_step = 1;
            updateTenantShow();
        }else if(selected_type =='landlord' && pagenumber == 5){
            var countSize = $("#foundTenantRows").find('.tenantStartRentalDiv').size();
            for(var i =0; i< countSize; i++){
                if($("#startDate"+i).val() == ''){
                    alert("Please select start date of rental contract of all tenants.");
                    return;
                }
                if(isDate($("#startDate"+i).val()) == false){
                    alert("Please select correct date  for start date of rental contract of all tenants.");
                    return;
                }
            }
        }else {
            next_step = 0;
        }
        if(selected_type == 'tenant' && tenant_address_check == 0 && pagenumber == 4){
            $("#tenantAddressError").hide();
            $("#tenantAddressInvalidError").hide();
            $("#tenantStartDateError").hide();
            $("#tenantStartDateValidError").hide();
            var address = $("#tenant-address").val();
            if(address == '') { $("#tenantAddressError").show(); return;}
            if($("#tenant-start-date").val() == '') {
                $("#tenantStartDateError").show(); return;
            }
            if(isDate($("#tenant-start-date").val()) == false){
                $("#tenantStartDateValidError").show(); return;
            }
            next_step_review = 1;
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    for (var i = 0; i < results[0].address_components.length; i++) {
                        var addressType = results[0].address_components[i].types[0];
                        if (componentForm[addressType]) {
                            var val = results[0].address_components[i][componentForm[addressType]];
                            if (addressType == 'locality') {
                                setAddress['city'] = val;
                            } else if (addressType == 'street_number') {
                                setAddress['street_no'] = val;
                            } else if (addressType == 'route') {
                                setAddress['street'] = val;
                            } else if (addressType == 'postal_code') {
                                setAddress['post_code'] = val;
                            } else if (addressType == 'administrative_area_level_1') {
                                setAddress['state'] = val;
                            } else if (addressType == 'country') {
                                setAddress['country'] = val;
                            }
                        }
                    }
                    setAddress['lat'] = results[0].geometry.location.lat();
                    setAddress['lng'] = results[0].geometry.location.lng();
                    console.log(setAddress);
                    if(setAddress['street_no'] == '' || setAddress['country'] == '' || setAddress['post_code'] == '' || setAddress['city'] == '' || setAddress['street'] =='' || setAddress['state'] == '' || setAddress['lat'] == '' || setAddress['lng'] == ''){
                        $("#tenantAddressInvalidError").show();
                        return;
                    }
                    $("#tenant-address-street").val(setAddress['street']);
                    $("#tenant-address-street-no").val(setAddress['street_no']);
                    $("#tenant-address-city").val(setAddress['city']);
                    $("#tenant-address-zipcode").val(setAddress['post_code']);
                    $("#tenant-address-state").val(setAddress['state']);
                    $("#tenant-address-country").val(setAddress['country']);
                    $("#tenant-address-lat").val(setAddress['lat']);
                    $("#tenant-address-lng").val(setAddress['lng']);

                    tenant_address_check = 1;
                    next_step_review = 0;
                    $("#review-next-tenant-action-button").trigger("click");
                }else{
                    next_step_review = 0;
                    tenant_address_check =0;
                    $("#tenantAddressInvalidError").show();
                    return;
                }
            });
        }
        if(next_step == 0 && next_step_review == 0) {
            animating = true;
            current_fs = $(this).parent();
            if(selected_type =='tenant' && pagenumber == 2){
                next_fs = $(this).parent().next();
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                next_fs = $(this).parent().next().next();
            }else if(selected_type =='landlord' && pagenumber == 3){
                next_fs = $(this).parent().next();
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                if(foundTenant == 1) {
                    next_fs = $(this).parent().next().next();
                }else{
                    $("#review-next-landlord-action-button").trigger('click');
                    next_fs = $(this).parent().next().next().next();
                }
            }else if(selected_type== 'tenant' && pagenumber == 4){
                next_fs = $(this).parent().next();
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                next_fs = $(this).parent().next().next();
            }else if(existUser == 1  && pagenumber == 1){
                if(selected_type =='tenant'){
                    next_fs = $(this).parent().next();
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                    next_fs = $(this).parent().next().next();
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                    next_fs = $(this).parent().next().next().next();
                }else if(selected_type == 'landlord'){
                    next_fs = $(this).parent().next();
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                    next_fs = $(this).parent().next().next();
                }
            }else {
                next_fs = $(this).parent().next();
            }
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
    function updateTenantShow(){
        var indexCheck = 0;
        var tenants = [];
        $("#property-rows").find('.col-md-12').each(function(index){
            var checkCountID = $(this).attr('id');
            var checkCount = checkCountID.split('property-row');
            var sendCheckRowID = checkCount[1];
            tenants[index] = $("#emailTenant"+sendCheckRowID).val();
            indexCheck ++;
        });
        if(tenants.length >0) {
            $.ajax({
                type:"POST",
                url:api_url,
                // dataType: 'json',
                data: {tenants : tenants},
                success: function(data) {
                    tenant_check = 1;
                    next_step = 0;
                    if(data.length >0 ) {
                        $("#foundTenantRows").find('.tenantStartRentalDiv').remove();
                        for(var i = 0 ; i < data.length; i++){
                            var newDiv = $("#cloneTenantStartRentalDiv").clone();
                            newDiv.find('#cloneTenantName').val(data[i]['name']);
                            newDiv.find('#cloneTenantName').attr("id", "tenantName"+i);
                            // newDiv.find('#cloneStartDate').val(format(data[i]['start_date']));
                            // newDiv.find('#cloneStartDate').val('');
                            newDiv.find('.clonedatepicker').addClass('datepicker');
                            newDiv.find('.clonedatepicker').removeClass('clonedatepicker');
                            newDiv.find('#cloneStartDate').attr("id", "startDate"+i);
                            newDiv.find('.datepicker').datepicker({uiLibrary: 'bootstrap4'});
                            if(data[i]['start_date'] != '') {
                                newDiv.find('.datepicker').datepicker("value", format(data[i]['start_date']));
                            }
                            newDiv.find('#cloneTenantID').val(data[i]['id']);
                            newDiv.find('#cloneTenantID').attr("id", "tenantID"+i);
                            newDiv.find('#cloneExistTenantEmail').val(data[i]['email']);
                            newDiv.find('#cloneExistTenantEmail').attr("id", "existTenantEmail"+i);
                            newDiv.attr("id", "tenantStartRentalDiv"+i);
                            newDiv.show();
                            $("div#foundTenantRows:last").append(newDiv);
                        }
                        // $('.datepicker').datepicker({
                        //     uiLibrary: 'bootstrap4'
                        // });
                        foundTenant = 1;
                        $("#next-landlord-action-button-step").trigger('click');
                    }else {
                        foundTenant = 0;
                        $("#next-landlord-action-button-step").trigger('click');
                    }
                }
            });
        }else{
            next_step = 0;
            foundTenant = 0;
            tenant_check = 1;
            $("#next-landlord-action-button-step").trigger('click');
        }
    }
    function format(inputDate) {
        var date = new Date(inputDate);
        if (!isNaN(date.getTime())) {
            // Months use 0 index.
            return date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
        }
    }
    function isDate(txtDate)
    {
        var currVal = txtDate;
        if(currVal == '')
        return false;
        //Declare Regex
        var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
        var dtArray = currVal.match(rxDatePattern); // is format OK?
        if (dtArray == null)
        return false;
        //Checks for mm/dd/yyyy format.
        dtMonth = dtArray[1];
        dtDay= dtArray[3];
        dtYear = dtArray[5];

        if (dtMonth < 1 || dtMonth > 12)
            return false;
        else if (dtDay < 1 || dtDay> 31)
            return false;
        else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
            return false;
        else if (dtMonth == 2)
            {
                var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
                if (dtDay> 29 || (dtDay ==29 && !isleap))
                return false;
            }
            return true;
    }

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
    function sendSubmitContent() {
        $.ajax({
            type:"POST",
            url:submit_url,
            data: $("#NewUserWizardForm").serialize(),
            success: function(data) {
                if(data == 'success') {
                    window.location.href = '/new-user-wizard-video';
                }
            }
        });
    }

    $(".previous").click(function() {
        if (animating) return false;
        animating = true;
        var pagenumber = $(this).attr('data-page');
        current_fs = $(this).parent();
        var selected_type = $('input[name=select-type]:checked').val();
        var existUser = $("#existUser").val();
        if(selected_type== 'tenant' && pagenumber ==4){
            if(existUser == 1){
                previous_fs = $(this).parent().prev().prev().prev();
            }else{
                previous_fs = $(this).parent().prev().prev();
            }

        }else if(selected_type=='landlord' && pagenumber == 3){
            if(existUser == 1) {
                previous_fs = $(this).parent().prev().prev();
            }else{
                previous_fs = $(this).parent().prev();
            }
        }else if(selected_type== 'tenant' && pagenumber ==6){
            previous_fs = $(this).parent().prev().prev();
        }else if (selected_type== 'landlord' && pagenumber ==5){
            previous_fs = $(this).parent().prev().prev();
        }else if (selected_type== 'landlord' && pagenumber ==6){
            if(foundTenant == 0) {
                previous_fs = $(this).parent().prev().prev().prev();
            }else{
                previous_fs = $(this).parent().prev();
            }
        }else{
            previous_fs = $(this).parent().prev();
        }
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        if(selected_type== 'tenant' && pagenumber ==4){
            var  previous_current_fs = $(this).parent().prev();
            $("#progressbar li").eq($("fieldset").index(previous_current_fs)).removeClass("active");
            if(existUser == 1){
                var  previous_current_fs = $(this).parent().prev().prev();
                $("#progressbar li").eq($("fieldset").index(previous_current_fs)).removeClass("active");
            }
        }
        if((selected_type== 'landlord' && pagenumber ==5) || (selected_type== 'landlord' && pagenumber ==6)){
            tenant_check = 0;
            var  previous_current_fs = $(this).parent().prev().prev();
            $("#progressbar li").eq($("fieldset").index(previous_current_fs)).removeClass("active");
        }
        if(selected_type == 'tenant' && pagenumber == 6){
            tenant_address_check =0;
        }
        if(selected_type == 'landlord' && pagenumber == 3) {
            if(existUser == 1) {
                var  previous_current_fs = $(this).parent().prev();
                $("#progressbar li").eq($("fieldset").index(previous_current_fs)).removeClass("active");
            }
        }
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
    // display review page
    $('#review-next-landlord-action-button, #review-next-tenant-action-button').click(function() {
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
        if(next_step_review == 0){
            $("#progressbar").css('visibility', 'hidden');
            $('#review-content').html('');
            $('fieldset').each(function(index) {
                var pageNum = $(this).find('.action-button').attr('data-page');
                var selected_type = $('input[name=select-type]:checked').val();
                var existUser = $("#existUser").val();
                if(pageNum != 1 && pageNum != 6) {
                    if(pageNum == 2){
                        var strHtml = '<div class="field-title">' + (pageNum) + '. ' + titles[pageNum - 1];
                        if(existUser != 1) {
                            strHtml += '<span class="pagelink" page-num="' + pageNum + '">&nbsp;&nbsp;[Edit]</span>';
                        }
                        strHtml += '</div>';
                    }else if(pageNum == 3 && selected_type == 'landlord'){
                        var strHtml = '<div class="field-title">' + (pageNum) + '. ' + titles[pageNum - 1];
                        strHtml += '<span class="pagelink" page-num="' + pageNum + '">&nbsp;&nbsp;[Edit]</span>';
                        strHtml += '</div>';
                    }else if(pageNum == 4 && selected_type =='tenant'){
                        var strHtml = '<div class="field-title">' + (pageNum-1) + '. ' + titles[pageNum - 1];
                        strHtml += '<span class="pagelink" page-num="' + pageNum + '">&nbsp;&nbsp;[Edit]</span>';
                        strHtml += '</div>';
                    }else if(pageNum == 5 && selected_type =='landlord'){
                        if(foundTenant == 1) {
                            var strHtml = '<div class="field-title">' + (pageNum-1);
                            strHtml += '<span class="pagelink" page-num="' + pageNum + '">&nbsp;&nbsp;[Edit]</span>';
                            strHtml += '</div>';
                        }
                    }
                    if(pageNum == 2) {      // agreement page
                        strHtml += '<div class="field-content">';
                        if(selected_type == 'tenant') {
                            strHtml += 'As a tenant';
                        }else{
                            strHtml += 'As a landlord';
                        }
                        strHtml += '</div>';
                    } else if(pageNum == 4 && selected_type =='tenant') {       // landlord email and name
                        var values = '';
                        $(this).find('input[type=text]').each(function(idx) {
                            if($(this).attr('type') == 'button') return;
                            if(values == '') values += $(this).val();
                            else values += ', ' + $(this).val();
                        });
                        $(this).find('input[type=email]').each(function(idx) {
                            values += ', ' + $(this).val();
                        });
                        var rent_type_check =$('input[name=rent-type]:checked').val();
                        if(rent_type_check == 'apartment') {
                            values += ',  The whole house/apartment';
                        }else{
                            values += ',  A room in the house/apartment';
                        }
                        strHtml += '<div class="field-content">' + values + '</div>';
                    } else if(pageNum == 3 && selected_type == 'landlord'){
                        if(selected_type == 'landlord'){
                            var values = '';
                            values = $("#property-rows .addedDiv").length;
                            strHtml += '<div class="field-content">' + values + '</div>';
                        }
                    }else if(pageNum == 5 && selected_type == 'landlord'){
                        if(foundTenant == '1'){
                            var values = '';
                            values = $("#foundTenantRows .tenantStartRentalDiv").length;
                            strHtml += '<div class="field-content">' + values + '</div>';
                        }
                    }
                    $('#review-content').append(strHtml);
                }
            })

            $('span.pagelink').unbind('click').bind('click', pagelinkClkEvt);
        }
    });
    // gp back to form page
    $('.backform.action-button').click(function() {        
        $("#progressbar").css('visibility', 'visible');        
    });

    $('#datepicker').on('change', function() {
        console.log('change');
        if($(this).val() != "") $('.next[data-page="5"]').attr("disabled", false);
    })
	
    function pagelinkClkEvt() {
        console.log('go to page');
        var pageNum = $(this).attr('page-num');
        console.log(pageNum);
        if(pageNum == 4) {
            tenant_address_check = 0;
        }
        if(pageNum == 3) {
            tenant_check = 0;
        }
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
function changeUserType(type) {
    if(type == 'tenant') {
        $("#landlord-type").removeClass('user-type-selected');
        $("#tenant-type").addClass('user-type-selected');
    }else {
        $("#tenant-type").removeClass('user-type-selected');
        $("#landlord-type").addClass('user-type-selected');
    }
    $('.next[data-page="2"]').attr("disabled", false);
}

var titles = ['','How will you use Rentling?','',
    'Rentling for tenants'];

function  saveDetails() {
    $("#addressError").hide();
    $("#emailTenantError").hide();
    $("#nameTenantError").hide();
    $("#emailTenantIncorrectError").hide();
    $("#tenantRentError").hide();
    $("#addressInvalidError").hide();
    var geocoder = new google.maps.Geocoder();
    var address = $("#address").val();
    if(address == '') { $("#addressError").show(); return;}
    if($("#emailTenant").val() == '') { $("#emailTenantError").show(); return;}
    if($("#nameTenant").val() == '') { $("#nameTenantError").show(); return;}
    if($("#tenantRent").val() == '') { $("#tenantRentError").show(); return;}
    var emailTenant = $('#emailTenant').val();

    if(!( /(.+)@(.+){2,}\.(.+){2,}/.test(emailTenant) )){
        $("#emailTenantIncorrectError").show(); return;
    }
    geocoder.geocode( { 'address': address}, function(results, status) {
        if(status == google.maps.GeocoderStatus.OK){
            for (var i = 0; i < results[0].address_components.length; i++) {
                var addressType = results[0].address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = results[0].address_components[i][componentForm[addressType]];
                    if(addressType == 'locality'){
                        setAddress['city'] = val;
                    }else if(addressType == 'street_number'){
                        setAddress['street_no'] = val;
                    }else if(addressType == 'route'){
                        setAddress['street'] = val;
                    }else if(addressType == 'postal_code'){
                        setAddress['post_code'] = val;
                    }else if(addressType == 'administrative_area_level_1'){
                        setAddress['state'] = val;
                    }else if(addressType == 'country'){
                        setAddress['country'] = val;
                    }
                }
            }
            setAddress['lat'] = results[0].geometry.location.lat();
            setAddress['lng'] = results[0].geometry.location.lng();
            console.log(setAddress);
            if(setAddress['street_no'] == '' || setAddress['country'] == '' || setAddress['post_code'] == '' || setAddress['city'] == '' || setAddress['street'] =='' || setAddress['state'] == '' || setAddress['lat'] == '' || setAddress['lng'] == ''){
                $("#addressInvalidError").show();
                return;
            }
            foundTenant =0;
            if(editDiv ==0){
                    var newDiv = $("#cloneObjectDiv").clone();
                    newDiv.show();
                    newDiv.find('#cloneAddress').val(address);
                    newDiv.find('#cloneAddress').attr("id", "address"+countDiv);
                    newDiv.find('#cloneEmailTenant').val($("#emailTenant").val());
                    newDiv.find('#cloneEmailTenant').attr("id", "emailTenant"+countDiv);
                    newDiv.find('#cloneNameTenant').val($("#nameTenant").val());
                    newDiv.find('#cloneNameTenant').attr("id", "nameTenant"+countDiv);
                    if( $("#tenantRent").val() == 'apartment'){
                        var tenantRent = 'Whole Apartment';
                    }else{
                        var tenantRent ='Only a room';
                    }
                    newDiv.find('#cloneTenantRent').val(tenantRent);
                    newDiv.find('#cloneTenantRent').attr("id", "tenantRent"+countDiv);
                    newDiv.find('#cloneZipCode').val(setAddress['post_code']);
                    newDiv.find('#cloneZipCode').attr("id", "zipCode"+countDiv);
                    newDiv.find('#cloneCity').val(setAddress['city']);
                    newDiv.find('#cloneCity').attr("id", "city"+countDiv);
                    newDiv.find('#cloneState').val(setAddress['state']);
                    newDiv.find('#cloneState').attr("id", "state"+countDiv);
                    newDiv.find('#cloneCountry').val(setAddress['country']);
                    newDiv.find('#cloneCountry').attr("id", "country"+countDiv);
                    newDiv.find('#cloneStreet').val(setAddress['street']);
                    newDiv.find('#cloneStreet').attr("id", "street"+countDiv);
                    newDiv.find('#cloneStreetNo').val(setAddress['street_no']);
                    newDiv.find('#cloneStreetNo').attr("id", "streetNo"+countDiv);
                    newDiv.find('#cloneLat').val(setAddress['lat']);
                    newDiv.find('#cloneLat').attr("id", "lat"+countDiv);
                    newDiv.find('#cloneLng').val(setAddress['lng']);
                    newDiv.find('#cloneLng').attr("id", "lng"+countDiv);
                    newDiv.attr("id", "property-row"+countDiv);
                    $("div#property-rows:last").append(newDiv);
                    countDiv ++;
            }else{
                $("#address"+editRowNumber).val($("#address").val());
                $("#emailTenant"+editRowNumber).val($("#emailTenant").val());
                $("#nameTenant"+editRowNumber).val($("#nameTenant").val());
                if( $("#tenantRent").val() == 'apartment'){
                    var tenantRent = 'Whole Apartment';
                }else{
                    var tenantRent ='Only a room';
                }
                $("#tenantRent"+editRowNumber).val(tenantRent);
                $("#zipCode"+editRowNumber).val(setAddress['post_code']);
                $("#city"+editRowNumber).val(setAddress['city']);
                $("#state"+editRowNumber).val(setAddress['state']);
                $("#country"+editRowNumber).val(setAddress['country']);
                $("#street"+editRowNumber).val(setAddress['street']);
                $("#streetNo"+editRowNumber).val(setAddress['street_no']);
                $("#lat"+editRowNumber).val(setAddress['lat']);
                $("#lng"+editRowNumber).val(setAddress['lng']);
            }
            /**set Empty ***/
                $("#address").val('');
                $("#tenantRent").val('');
                $("#emailTenant").val('');
                $("#nameTenant").val('');
        }else{
            $("#addressInvalidError").show();
            return;
        }
    });
}
function removeDetails(obj){
    foundTenant =0;
    $(obj).parent().parent().parent().remove();
}
function editDetails(obj){
    var parent = $(obj).parent().parent().parent();
    var checkCountID = parent.attr('id');
    var checkCount = checkCountID.split('property-row');
    editRowNumber = checkCount[1];
    editDiv = 1;
    $("#address").val( parent.find("#address"+editRowNumber).val());
    $("#emailTenant").val( parent.find("#emailTenant"+editRowNumber).val());
    $("#nameTenant").val( parent.find("#nameTenant"+editRowNumber).val());
    if(parent.find("#tenantRent"+editRowNumber).val() == 'Whole Apartment'){
        $("#tenantRent").val('aprtment');
    }else{
        $("#tenantRent").val('room');
    }

}

var placeSearch, autocomplete, autocompleteTenant;
var setAddress = [];
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
    autocomplete = new google.maps.places.Autocomplete((document.getElementById('address')),{types: ['geocode']});
    autocompleteTenant = new google.maps.places.Autocomplete((document.getElementById('tenant-address')),{types: ['geocode']});
    console.log(autocomplete);

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
    autocompleteTenant.addListener('place_changed', fillInAddressTenant);
}
function fillInAddressTenant(){
    var place = autocompleteTenant.getPlace();
    setAddressFromPlace(place);
}
function fillInAddress() {
    console.log("fill address");
    // Get the place details from the autocomplete object.
    console.log(autocomplete);
    var place = autocomplete.getPlace();
    setAddressFromPlace(place);
}

function setAddressFromPlace(place){
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            if(addressType == 'locality'){
                setAddress['city'] = val;
            }else if(addressType == 'street_number'){
                setAddress['street_no'] = val;
            }else if(addressType == 'route'){
                setAddress['street'] = val;
            }else if(addressType == 'postal_code'){
                setAddress['post_code'] = val;
            }else if(addressType == 'administrative_alea_level_1'){
                setAddress['state'] = val;
            }else if(addressType == 'country'){
                setAddress['country'] = val;
            }
        }
    }
}




    
