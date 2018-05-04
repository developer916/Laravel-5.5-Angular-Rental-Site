'use strict';

RentomatoApp.controller('MessagesController', function ($rootScope, $scope, $http, $uibModal, $stateParams, MessageService, TagService, UserService, toaster, $filter) {
    $scope.messages = {};
    $scope.visibleUsers = []; // TODO remove when recipients done
    $scope.recipients = [];
    $scope.tags = {all: [], selected: []};
    $scope.newTagFormDisabled = false;
    $scope.editTagInModal = -1;

    /**
     * Possible colors for tags
     */
    $scope.colors = [{rgb: 106, hex: "#dc4437", name: "rentomato"}, {rgb: 47, hex: "#CD5C5C", name: "indianred"}, {rgb: 87, hex: "#FF4500", name: "orangered"},
        {rgb: 17, hex: "#008B8B", name: "darkcyan"}, {rgb: 18, hex: "#B8860B", name: "darkgoldenrod"}, {rgb: 68, hex: "#32CD32", name: "limegreen"},
        {rgb: 42, hex: "#FFD700", name: "gold"}, {rgb: 77, hex: "#bdbdbd", name: "gray"}];
    /**
     * Available icons for tags
     */
    $scope.availableIcons = ["home", "bed", "wrench", "share", "envelope", "reply", "reply-all", "envelope-o", "building", "building-o", "money", "check", "check-square-o", "globe", "dot-circle-o", "file", "book", "file-text", "exclamation", "tint", "eur"];

    // Helper function
    function idToIndex(id) {
        for (var x = 0; x < $scope.messages.length; x++) {
            if ($scope.messages[x].id == id)
                return x;
        }
        return -1;
    }

    /**
     * Retrieve all the messages
     * TODO Only perform when in the overview
     */
    MessageService.getMessages().then(function (response) {
        if (response.success) {
            $scope.messages = response.messages;

            // Set the current message if one is selected
            if ($rootScope.$state.current.name == "messages.view" && $stateParams && $stateParams.id) {
                var index = idToIndex($stateParams.id);
                $scope.message = $scope.messages[index];
                $scope.tags.selected = $scope.messages[index].tags;
                if ($scope.message.pivot.read == "0") {
                    $scope.message.pivot.read = "1";
                    $scope.messages[index].pivot.read = "1";
                    MessageService.update($scope.message);
                }
            }
        } else {
            toaster.error('Something went wrong while retrieving your messages.');
        }
    });

    /**
     * Retrieve possible recipients
     */
    if ($rootScope.$state.current.name == "messages.compose" ||
        $rootScope.$state.current.name == "messages.composeTo" ||
        $rootScope.$state.current.name == "messages.composing" ||
        $rootScope.$state.current.name == "messages.composingType") {

        // Helper function: used to distinguish unique entries in the select2 box.
        $scope.trackRecipientsBy = function(type, id) { return type + id; };

        // Helper functions to determine who is addressed
        $scope.isAddressed = function(type) {
            console.log($scope.compose['recipients']);
            if ($scope.compose['recipients']) {
                for (var x = 0; x < $scope.compose['recipients'].length; x++) {
                    if ($scope.compose['recipients'][x].id.split('|')[0] == type) return true;
                }
            }
            return false;
        };
        // Helper functions: get recipient type / id
        $scope.rType = function(id) { return id.split('|')[0]; };
        $scope.rId = function(id) { return id.split('|')[1]; };

        console.log($scope.rType);
        var visibleUsersPromise = UserService.getVisibleUsers().then(function (response) {
            $scope.visibleUsers = response;
        });

        var recipientsPromise = UserService.getRecipients().then(function(response) {
            var recipients = [];

            // Add recipient_type flag for each of the entries and add it to the collection
            for (var type in response) { if (response.hasOwnProperty(type)) {
                for (var entry in response[type]) { if (response[type].hasOwnProperty(entry)) {
                    response[type][entry].id = type + '|' + response[type][entry].id;
                    response[type][entry].recipient_type = type;
                    recipients.push(response[type][entry]);
                }}
            }}

            $scope.recipients = recipients;
        });
    }

    /**
     * Retrieve all the tags for the current user
     */
    UserService.getTags().then(function(response) { $scope.tags.all = response; });

    /**
     * Send a message
     */
    $scope.sendMessage = function() {
        $scope.sendingMessage = true;
        var data = {
            'recipients':   $scope.compose['recipients'],
            'subject':      $scope.compose['subject'],
            'text':         $scope.compose['text'],
            'priority':     $scope.compose['priority'],
            'type':         ($scope.compose['announcement'] ? 'announcement' : 'message')
        };
        MessageService.sendMessage(data).then(function(response) {
            if (response.success) {
                $scope.messageSent = true;
                $rootScope.$state.go("messages");
                toaster.success($filter('translate')('Your message has been sent!'));
            } else {
                $scope.sendingMessage = false;
                toaster.error($filter('translate')('There was an error, please try again.'));
            }
        });
    };

    /**
     * Delete a message
     * @param id message id
     */
    $scope.deleteMessage = function(id) {
        MessageService.deleteMessage(id).then(function(response) {
            if (response.success) {
                toaster.success('Message has been deleted');
                $scope.messages.splice(messageIdToIndex(id), 1);
                if ($rootScope.$state.current.name == "messages.view") {
                    $rootScope.$state.go("messages");
                }
            } else
                toaster.error($filter('translate')('Something went wrong!'));
        });
    };

    /**
     * Star or unstar a message
     * @param id message to be starred
     */
    $scope.toggleStar = function(index) {
        $scope.messages[index].pivot['starred'] = ($scope.messages[index].pivot['starred'] == "1" ? "0" : "1");
        MessageService.update($scope.messages[index]);
    };

    /**
     * Everything tag related for messages
     * - Toggle edit form
     * - Updating tags for a message
     * - Creation of tags on the fly
     * - Tags management (modal)
     */
    // Toggle editting form
    $scope.toggleEditTags = function() { $scope.editTags = !$scope.editTags; };

    // Send the new tags for a message to backend
    $scope.updateTags = function() {
        MessageService.updateTags({tags: $scope.tags.selected, message: $stateParams.id}).then(function(response) {
            if (response.success == 1) {
                $scope.message.tags = $scope.tags.selected; $scope.editTags = false; $scope.messages[idToIndex($stateParams.id)].tags = $scope.tags.selected;
                toaster.success($filter("translate")("Tags have been updated"));
            } else {
                toaster.error($filter("translate")("Error while updating tags. Please try again."));
            }
        });
    };

    // Function used by ui-select to create new tag objects.
    // ID is set to -1 by default in order to recognise in backend.
    $scope.createTag = function (tagName) { return { id: -1, name: tagName, icon: 'tag', color: '#bdbdbd' }; };

    // Function to delete a tag
    $scope.deleteTag = function (index) {
        var tagID = $scope.tags.all[index].id;
        MessageService.deleteTag(tagID).then(function(response) {
            if (response.success) {
                $scope.tags.all.splice(index, 1);
                toaster.success($filter('translate')('Tag has been deleted'));
            } else {
                toaster.error($filter('translate')('Error while deleting tag.'));
            }
        });
    };


    // Function used to display the modal
    $scope.manageTags = function() {
        //$('#manage-tags-modal').modal('show');
        var modalInstance = $uibModal.open({
            templateUrl: 'tagModalContent.html',
            controller: 'TagModalInstanceCtrl',
            scope:$scope
        });
    };

    // Function to create a new tag through the modal
    $scope.createNewTag = function(newTagForm) {
        $scope.newTagFormDisabled = true;

        // Create the tag;
        TagService.createTag(newTagForm).then(function(response) {
            if (response.success) {
                toaster.success($filter('translate')('Tag created!'));
                $scope.tags.all.push(response.tag); $scope.newTagFormDisabled = false;
            } else {
                if (response.reason == null) {
                    toaster.error($filter('translate')('Error while creating your tag!'));
                } else {
                    if (response.reason == "duplicate") {
                        toaster.warning($filter('translate')('A tag with the specified name already exists!'));
                    }
                }
                $scope.newTagFormDisabled = false;
            }
        });
    };

    // Enable the edit form in the modal
    $scope.setEditTagInModal = function(index) { $scope.editTagInModal = index; };
    // Disable the edit form in the modal
    $scope.cancelEditTagInModal = function() { $scope.editTagInModal = -1; };
    // Save the tag in the modal
    $scope.saveEditTagInModal = function(tag) {
        TagService.updateTag(tag).then(function(response) {
            if (response.success) {
                toaster.success($filter('translate')('Tag successfully updated.'));
            } else {
                toaster.error($filter('translate')('Something went wrong while trying to update the tag.'));
            }
        });
        $scope.editTagInModal = -1;
    };

    /**
     * Composing: replying to other message
     * Prefill all data that is already known.
     */
    // If we are replying to someone, prefill the fields.
    if (($rootScope.$state.current.name == "messages.composing" || $rootScope.$state.current.name == "messages.composingType") && $stateParams.id) {
        $scope.loadingDetails = true;
        if ($stateParams.type == null) $stateParams.type = "user";

        MessageService.getReplyDetails($stateParams.id, $stateParams.type).then(function (response) {
            if (response.success) {
                $scope.replyTo = response.message;
                $scope.compose['subject'] = $scope.replyTo.subject;
                $scope.compose['priority'] = 0;

                // Make the data match the select2 dropdown format (u|ID or p|ID)
                if ($stateParams.type == "user") {
                    $scope.respondingTo = [response.user];
                } else if ($stateParams.type == "reply-all") {
                    $scope.respondingTo = response.recipients;
                }

                visibleUsersPromise.then(function(response) {
                    $scope.compose['recipients'] = $scope.respondingTo;
                });
                $scope.loadingDetails = false;
            }
        });
    }

    /**
     * Composing: addressed a specific person, also used for announcements
     */
    // If we are composing a message to a specific user
    if (($rootScope.$state.current.name == "messages.composeTo") && $stateParams.type && $stateParams.id) {
        switch ($stateParams.type) {
            case "user":
                $scope.searchId = 'u|' + $stateParams.id;
                break;
            case "property":
                $scope.searchId = 'p|' + $stateParams.id;
                break;
        }

        recipientsPromise.then(function(response) {
            if ($scope.searchId) {
                for (var x = 0; x < $scope.recipients.length; x++) {
                    if ($scope.recipients[x].id == $scope.searchId) {
                        $scope.compose['recipients'] = [$scope.recipients[x]];
                        break;
                    }
                }
            }
        });
    }
});

RentomatoApp.controller('TagModalInstanceCtrl',['$scope','$rootScope','$uibModalInstance', function ($scope,$rootScope,$uibModalInstance) { //future minify
    // Changing the selected color.
    $scope.changeColor = function(color) { $scope.$parent.tags.all[$scope.$parent.editTagInModal].color = color; };

    // Close function for the modal.
    $scope.close = function() { $uibModalInstance.dismiss('cancel'); };
}]);