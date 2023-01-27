define([
        "jquery",
        "Magento_Ui/js/modal/modal",
        'text!Magenmagic_OrderByPhone/template/modal/modal-popup.html',
    ], function ($, modal, popupTpl) {
        var ExampleModal = {
            initModal: function (config, element) {
                var previewPopup = $('<div/>',{id : 'quick-order-modal' });

                var options = {
                    type: 'popup',
                    title: 'Quick Order',
                    modalClass: 'quick-order-modal',
                    popupTpl: popupTpl,
                    buttons: []
                };

                var modalPopup = previewPopup.modal(options);

                modalPopup.on('modalclosed', function () {
                    $('#quick-order-form').trigger('reset');
                });

                $(element).click(function () {
                    console.log(window.checkout);
                    modalPopup.modal('openModal');
                    $('.popup-product-name').text(config.productName);
                });
            }
        };
        return {
            'quick-order-modal': ExampleModal.initModal
        };
    }
);
