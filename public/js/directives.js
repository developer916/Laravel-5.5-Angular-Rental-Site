/***
 GLobal Directives
 ***/

// Route State Load Spinner(used on page or content load)
RentomatoApp.directive('ngSpinnerBar', ['$rootScope',
    function ($rootScope) {
        return {
            link: function (scope, element, attrs) {
                // by defult hide the spinner bar
                element.addClass('hide'); // hide spinner bar by default

                // display the spinner bar whenever the route changes(the content part started loading)
                $rootScope.$on('$stateChangeStart', function () {
                    element.removeClass('hide'); // show spinner bar
                });

                // hide the spinner bar on rounte change success(after the content loaded)
                $rootScope.$on('$stateChangeSuccess', function () {
                    element.addClass('hide'); // hide spinner bar
                    $('body').removeClass('page-on-load'); // remove page loading indicator
                    Layout.setSidebarMenuActiveLink('match'); // activate selected link in the sidebar menu

                    // auto scorll to page top
                    setTimeout(function () {
                        RT.scrollTop(); // scroll to the top on content load
                    }, $rootScope.settings.layout.pageAutoScrollOnLoad);
                });

                // handle errors
                $rootScope.$on('$stateNotFound', function () {
                    element.addClass('hide'); // hide spinner bar
                });

                // handle errors
                $rootScope.$on('$stateChangeError', function () {
                    element.addClass('hide'); // hide spinner bar
                });
            }
        };
    }
])

// Handle global LINK click
RentomatoApp.directive('a',
    function () {
        return {
            restrict: 'E',
            link: function (scope, elem, attrs) {
                if (attrs.ngClick || attrs.href === '' || attrs.href === '#') {
                    elem.on('click', function (e) {
                        e.preventDefault(); // prevent link click for above criteria
                    });
                }
            }
        };
    });

// Handle Dropdown Hover Plugin Integration
RentomatoApp.directive('dropdownMenuHover', function () {
    return {
        link: function (scope, elem) {
            elem.dropdownHover();
        }
    };
});


RentomatoApp.directive('dropzone', ['$cookies', '$filter', function ($cookies, $filter) {
    return {
        restrict: 'A',
        scope: {
            formData: "=",
            config: '=',
            removeFileDropzone: '&',
            files: "="
        },
        link: function (scope, element, attrs) {
            var config = {
                maxFilesize: 100,
                maxThumbnailFilesize: 10,
                parallelUploads: 1,
                maxFiles: 20,
                autoProcessQueue: true,
                headers: {'X-XSRF-TOKEN': $cookies.get('XSRF-TOKEN')},
                sending: function (file, xhr, formData) {
                    if (scope.formData) {
                        angular.forEach(scope.formData, function (v, k) {
                            formData.append(k, v);
                        });
                    }
                },

            };
            if (!scope.files) {
                scope.files = [];
            }
            if (scope.config) {
                angular.extend(config, scope.config);
            }
            if (!config.url) {
                console.log('dropzone directive needs url attribute');
            }

            Dropzone.autoDiscover = false;
            var dropzone = new Dropzone(element[0], config);

            var eventHandlers = {
                'addedfile': function (file) {
                    if (scope.files && scope.files.length && this.files.length == config.maxFiles) {
                        this.removeFile(scope.files[0]);
                    }

                    if (this.files.length > config.maxFiles) {
                        this.removeFile(this.files[0]);
                    }
                    scope.file = file;
                    if (file.id) {
                        createButton(this, file);
                    }
                },
                'success': function (file, response) {
                    angular.forEach(response, function (v, k) {
                        file[k] = v;
                    });
                    if(file.id) {
                        scope.$apply(function(){
                            scope.files.push(file);
                        })
                    }
                    createButton(this, file);
                },
                'removedfile': function (file) {
                    if (file.id) {
                        scope.removeFileDropzone({file: file});
                        for (var i = 0; i < scope.files.length; i++) {
                            var iFile = scope.files[i];
                            if (iFile.id == file.id) {
                                scope.$apply(function() {
                                    scope.files.splice(i, 1);
                                });
                                break;
                            }
                        }
                    }
                }
            };
            angular.forEach(eventHandlers, function (handler, event) {
                dropzone.on(event, handler);
            });
            var createButton = function (dz, file) {
                var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block'>" + $filter('translate')('Remove file') + "</button>");
                removeButton.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dz.removeFile(file);
                });
                file.previewElement.appendChild(removeButton);
            }
            var update = function () {
                if (scope.files) {
                    $.each(scope.files, function (key, value) {
                        if(value.file) {
                            var mockFile = value;
                            mockFile.name = value.file.split('/').pop();
                            mockFile.size = value.file_size;
                            dropzone.emit("addedfile", mockFile);
                            dropzone.emit("complete", mockFile);
                            if (['jpg', 'png', 'jpeg', 'gif'].indexOf(value.file.split('.').pop().toLowerCase()) != -1) {
                                dropzone.emit("thumbnail", mockFile, value.file);
                                dropzone.createThumbnailFromUrl(mockFile, value.file);
                            }
                        }
                    });
                }
            }
            scope.$watch('files', function () {
               update();
            });
        }
    }
}]);

