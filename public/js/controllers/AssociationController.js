'use strict';

RentomatoApp.controller('AssociationController', function ($rootScope, $scope, $state, $stateParams, toaster, AssociationService, $filter, UserService, PropertyService) {
    

    var vm = this;
    vm.record = {
        id: ($stateParams.constantId) ? $stateParams.constantId : null,
    };

    vm.record.template = 'Initial content';

    vm.tinymceOptions = {
        selector: "textarea",
          height: 450,
          readonly: 0,
          plugins: [
            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
          ],

          toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
          toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
          toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",
          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'],

          menubar: false,
          toolbar_items_size: 'small',

          style_formats: [{
            title: 'Bold text',
            inline: 'b'
          }, {
            title: 'Red text',
            inline: 'span',
            styles: {
              color: '#ff0000'
            }
          }, {
            title: 'Red header',
            block: 'h1',
            styles: {
              color: '#ff0000'
            }
          }],         
          
          init_instance_callback: function () {
            window.setTimeout(function() {
              $("#div").show();
             }, 1000);
          }
    };

    vm.countryChanged = function (id) {
        console.log('country changed');        
        AssociationService.getPropertyList(vm.countryId).then(function (response) {
            vm.availablePropertyList = response;            
            console.log("property list");
            console.log(vm.availablePropertyList);                  
        });   
    }     
     

    vm.saveData = function () {
        console.log('saveData');
        console.log(vm.record.template);
        if (vm.record.propertyId == '') {
            return false;
        }

        if (vm.record.email == '') {
            return false;
        }

        if (!validateEmail(vm.record.email)) {
          vm.isEmailInvalid = true;
            return false;
        }
        AssociationService.createAssociation(vm.record).then(function (response) {
            if (response.status == 1) {
                toaster.success($filter('translate')('Association created.'));
                setTimeout(function() {
                  $state.go('dashboard');
                }, 2000);
                
            }
        });
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

});
