'use strict';

RentomatoApp.controller('PlanningController', function($rootScope, $scope, $http, toaster, PlanningService) {

    // Declaration of scope variables
    $scope.tasks = [];
    $scope.selectedTask = null;

    // Fetch tasks
    PlanningService.getTasks().then(function(response) {
        $scope.tasks = response;
    });

    // Delete a task from the DB and $scope.tasks.
    $scope.deleteTask = function(index) {

        // Deselect the task if it's selected
        if ($scope.selectedTask == index) $scope.deselectTask();

        PlanningService.deleteTask($scope.tasks[index].id).then(function(response) {
            if (response.success) {
                toaster.success('Task deleted.');
                $scope.tasks.splice(index, 1);
            } else {
                toaster.error('Something went wrong!');
            }
        });
    };

    // Marks a task as being (un)complete. Also updates $scope.tasks.
    $scope.toggleCompleteTask = function(index) {
        $scope.tasks[index].completed = 1 - $scope.tasks[index].completed;
        updateTask(index);
    };

    // Selecting the task for the detail view
    $scope.selectTask = function(id) { $scope.selectedTask = id; };
    $scope.deselectTask = function() { $scope.selectedTask = null; };

    function updateTask(index) {
        PlanningService.updateTask($scope.tasks[index]).then(function(response) {
            if (response.success) {
                toaster.success('Task updated');
                $scope.tasks[index] = response.task;
            } else {
                toaster.error('Something went wrong');
            }
        });
    }
});
