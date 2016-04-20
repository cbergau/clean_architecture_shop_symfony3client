var app = angular.module('shopApp', ['ui.bootstrap']);

app.controller('ShopCtrl', function ($scope, $http, $modal, $log) {

    $scope.by = '';

    $scope.login = function (email, password) {
        $http.post('shop/authentication/login.json', {'email': email, 'password': password})
            .success(function (data) {
                location.href = location.href;
            })
            .error(function (data) {
                $scope.loginErrorMessages = data.messages.toString();
            });
    };

    $scope.updateBasket = function () {
        $http.get('shop/basket.json').success(function (data) {
            $scope.basket = data;
        });
    };

    $scope.changeBasket = function (position) {
        $http.post('shop/basket/change.json', position).success(function (data) {
            $scope.updateBasket();
        });
    };

    $scope.searchArticles = function () {
        if ($scope.by == '') {
            $scope.articles = null;
            return;
        }

        $http.get('shop/search.json?by=' + $scope.by).success(function (data) {
            $scope.articles = data;
        })
    };

    $scope.updateBasket();

    $scope.getDeliveryAddresses = function (successCallback) {
        $http.get('shop/deliveryaddress/list.json').success(function (data) {
            $scope.deliveryaddresses = data;
        }).success(successCallback);
    };

    $scope.openChangeInvoiceAddressForm = function (size) {
        var changeInvoiceAddressForm = $modal.open({
            templateUrl: 'changeInvoiceAddressForm.html',
            controller: ChangeInvoiceAddress,
            size: size
        });

        changeInvoiceAddressForm.result.then(function (currentInvoiceAddress) {
            $scope.currentInvoiceAddress = currentInvoiceAddress;
        });
    };

    $scope.openNewDeliveryAddressForm = function (size) {
        var newDeliveryAddressForm = $modal.open({
            templateUrl: 'newDeliveryAddressForm.html',
            controller: AddDeliveryAddress,
            size: size
        });
    };

    $scope.openDeliveryAddressBook = function (size) {
        $scope.getDeliveryAddresses(function () {
            var deliveryAddressBook = $modal.open({
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

var ChangeInvoiceAddress = function ($scope, $modalInstance, $http) {
    $scope.currentInvoiceAddress = {};
    $scope.saveInvoiceAddress = function () {
        $http.post('shop/invoiceaddress/change.json', $scope.currentInvoiceAddress).success(function (data) {
            $modalInstance.close($scope.currentInvoiceAddress);
        });
    };
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};

var AddDeliveryAddress = function ($scope, $modalInstance, $http) {
    $scope.address = {};

    $scope.saveDeliveryAddress = function () {
        $http.post('shop/deliveryaddress/add.json', $scope.address)
            .success(function (data) {
                $modalInstance.close();
            })
            .error(function (data) {

            });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    }
};

var DeliveryAddressBook = function ($scope, $modalInstance, $http, $log, deliveryaddresses) {
    $scope.deliveryaddresses = deliveryaddresses;

    $scope.selectDeliveryAddress = function (address) {
        $http.post('shop/deliveryaddress/select.json', address).success(function (data) {
            $modalInstance.close(address);
        });
    };

    $scope.editDeliveryAddress = function (address) {
        $log.error('editDeliveryAddress not implemented yet');
    };

    $scope.deleteDeliveryAddress = function (address) {
        $log.error('deleteDeliveryAddress not implemented yet');
    };

    $scope.ok = function () {
        $modalInstance.close();
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};