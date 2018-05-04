'use strict';

RentomatoApp.controller('ContractTemplateController', function ($rootScope, $scope, $state, $stateParams, toaster, ContractService, AssociationService, ContractTemplateService, $filter, UserService, PropertyService) {
    

    var vm = this;
    vm.record = {
        id: null,
    };

    vm.propEnable = false;  
    vm.isDefaultType = false;

    vm.record.template = 'Initial content';
    vm.record.contractTypeId = 2;

    vm.countryChanged = function (id) {
        console.log('country changed');
        AssociationService.getPropertyList(vm.record.countryId).then(function (response) {
            vm.availablePropertyList = response;                                          
        });        
        if(vm.record.contractTypeId && vm.record.countryId) {               
          console.log("request template");
          ContractTemplateService.getTemplate(vm.record.contractTypeId, vm.record.countryId, vm.record.propertyId).then(function (response) {
            console.log(response);        
              onReceiveTemplate(response);                        
          }); 
        }
    }  

    vm.contractTypeChanged = function (id) {
        console.log('type changed');                 
        
        if(vm.record.contractTypeId && vm.record.countryId) {               
          console.log("request template1");
          ContractTemplateService.getTemplate(vm.record.contractTypeId, vm.record.countryId, vm.record.propertyId).then(function (response) {
              console.log(response);                      
              onReceiveTemplate(response);                        
          }); 
        }
        if(vm.record.contractTypeId == 1 || vm.record.contractTypeId == 2) vm.propEnable = false;
        else vm.propEnable = true;
    }  

    vm.propertyChanged = function (id) {
        console.log('prop changed');        
        ContractTemplateService.getTemplate(vm.record.contractTypeId, vm.record.countryId, vm.record.propertyId).then(function (response) {
          console.log(response);        
            onReceiveTemplate(response);                        
        }); 
    }     
     

    vm.saveData = function () {
        console.log('saveData');
        console.log(vm.record.template);

        if(!isValidTemplate()) return false;
        console.log('submit');

        ContractTemplateService.saveTemplate(vm.record).then(function (response) {
            if (response.status == 1) {
                toaster.success($filter('translate')('Contract template saved.'));                                
                templateForm.$submitted = false;
            }
        });
    }

    function onReceiveTemplate(response) {
      if(response.data) {
        vm.record.id = response.data.id;
        vm.record.template = response.data.template;                          
        vm.record.useAsAddendum = (response.data.use_as_addendum == "1") ? true : false;
        console.log(vm.record.useAsAddendum);
      } else {
        vm.record.id = null;
        vm.record.template = '';
        vm.record.useAsAddendum = false;
      }
    }

    function isValidTemplate() {
      console.log('validate');
      console.log(vm.record.countryId);
      if(!vm.record.countryId || !vm.record.contractTypeId) {        
        return false;
      } 
      if(((vm.record.contractTypeId == 3) || (vm.record.contractTypeId == 4)) && !vm.record.propertyId) {                
        return false;
      }
      return true;
    }

    vm.formFields = ContractService.formFields;
    vm.formFields1 = ContractService.formFields1;
    console.log(vm.formFields);
    // variables for tinymceOptions
    var v_plugins = [
            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
          ] 
    var v_toolbar1 = "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect | mybutton";
    var v_toolbar2 = "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor";
    var v_toolbar3 = "table | hr removeformat | subscript superscript | charmap emoticons | print | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft";
    var v_style_formats = [{
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
          }]
    vm.tinymceOptions = {
        selector: "textarea",
          height: 450,
          plugins: v_plugins,
          toolbar1: v_toolbar1,
          toolbar2: v_toolbar2,
          toolbar3: v_toolbar3,
          menubar: false,
          toolbar_items_size: 'small',
          style_formats: v_style_formats,          
          
          init_instance_callback: function () {
            window.setTimeout(function() {
              $("#div").show();
             }, 1000);
          },

          setup: function (editor) {
            editor.addButton('mybutton', {
              type: 'listbox',
              text: 'Form fields',
              icon: false,
              onselect: function (e) {
                editor.insertContent(this.value());
                this.value('');
              },
              values: vm.formFields,
              onPostRender: function () {
                // Select the second item by default
                this.value(vm.formFields[1]);
              }
            });
          }

    };

    vm.tinymceOptionsForLandlord = {
        selector: "textarea",
          height: 450,
          plugins: v_plugins,
          toolbar1: v_toolbar1,
          toolbar2: v_toolbar2,
          toolbar3: v_toolbar3,
          menubar: false,
          toolbar_items_size: 'small',
          style_formats: v_style_formats,          
          
          init_instance_callback: function () {
            window.setTimeout(function() {
              $("#div").show();
             }, 1000);
          },

          setup: function (editor) {
            editor.addButton('mybutton', {
              type: 'listbox',
              text: 'Form fields',
              icon: false,
              onselect: function (e) {
                editor.insertContent(this.value());
                this.value('');
              },
              values: vm.formFields1,
              onPostRender: function () {
                // Select the second item by default
                this.value(vm.formFields1[1]);
              }
            });
          }

    };

    vm.tinymceOptionsForDefault = {
        selector: "textarea",
          height: 450,
          readonly: 1,
          plugins: v_plugins,
          toolbar1: v_toolbar1,
          toolbar2: v_toolbar2,
          toolbar3: v_toolbar3,
          menubar: false,
          toolbar_items_size: 'small',
          style_formats: v_style_formats
    };
});
