var app = angular.module('shopApp', ['ui.bootstrap']);

app.controller('ShopCtrl', function ($scope, $http, $uibModal, $log) {

    $scope.by = '';

    $scope.login = function (email, password) {
        $http.post('authentication/login.json', {'email': email, 'password': password})
            .success(function (data) {
                location.href = location.href;
            })
            .error(function (data) {
                $scope.loginErrorMessages = data.messages.toString();
            });
    };

    $scope.updateBasket = function () {
        $http.get('basket.json').success(function (data) {
            $scope.basket = data;
        });
    };

    $scope.changeBasket = function (position) {
        $http.post('basket/change.json', position).success(function (data) {
            $scope.updateBasket();
        });
    };

    $scope.searchArticles = function () {
        if ($scope.by == '') {
            $scope.articles = null;
            return;
        }

        $http.get('search.json?by=' + $scope.by).success(function (data) {
            $scope.articles = data;
        })
    };

    $scope.updateBasket();

    $scope.getDeliveryAddresses = function (successCallback) {
        $http.get('deliveryaddress/list.json').success(function (data) {
            $scope.deliveryaddresses = data;
        }).success(successCallback);
    };

    $scope.openChangeInvoiceAddressForm = function (size) {
        var changeInvoiceAddressForm = $uibModal.open({
            templateUrl: 'changeInvoiceAddressForm.html',
            controller: ChangeInvoiceAddress,
            size: size
        });

        changeInvoiceAddressForm.result.then(function (currentInvoiceAddress) {
            $scope.currentInvoiceAddress = currentInvoiceAddress;
        });
    };

    $scope.openNewDeliveryAddressForm = function (size) {
        var newDeliveryAddressForm = $uibModal.open({
            templateUrl: 'newDeliveryAddressForm.html',
            controller: AddDeliveryAddress,
            size: size
        });
    };

    $scope.openDeliveryAddressBook = function (size) {
        $scope.getDeliveryAddresses(function () {
            var deliveryAddressBook = $uibModal.open({
                templateUrl: 'deliveryAddressBook.html',
                controller: DeliveryAddressBook,
                size: size,
                resolve: {
                    deliveryaddresses: function () {
                        return $scope.deliveryaddresses;
                    }
                }
            });

            deliveryAddressBook.result.then(function (selectedItem) {
                $scope.selectedDeliveryAddress = selectedItem;
            });
        });
    };
});

var ChangeInvoiceAddress = function ($scope, $uibModalInstance, $http) {
    $scope.currentInvoiceAddress = {};
    $scope.saveInvoiceAddress = function () {
        $http.post('invoiceaddress/change.json', $scope.currentInvoiceAddress).success(function (data) {
            $uibModalInstance.close($scope.currentInvoiceAddress);
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
};

var AddDeliveryAddress = function ($scope, $uibModalInstance, $http) {
    $scope.address = {};

    $scope.saveDeliveryAddress = function () {
        $http.post('deliveryaddress/add.json', $scope.address)
            .success(function (data) {
                $uibModalInstance.close();
            })
            .error(function (data) {

            });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    }
};

var DeliveryAddressBook = function ($scope, $uibModalInstance, $http, $log, deliveryaddresses) {
    $scope.deliveryaddresses = deliveryaddresses;

    $scope.selectDeliveryAddress = function (address) {
        $http.post('deliveryaddress/select.json', address).success(function (data) {
            $uibModalInstance.close(address);
        });
    };

    $scope.editDeliveryAddress = function (address) {
        $log.error('editDeliveryAddress not implemented yet');
    };

    $scope.deleteDeliveryAddress = function (address) {
        $log.error('deleteDeliveryAddress not implemented yet');
    };

    $scope.ok = function () {
        $uibModalInstance.close();
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
};