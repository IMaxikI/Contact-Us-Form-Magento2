define([
        "jquery", "Magento_Ui/js/modal/modal"
    ], function($){
        var ExampleModal = {
            initModal: function(config, element) {
                $target =  $(config.target);

                var options = {
                    type: 'popup',
                    title: 'Quick Order',
                    modalClass: 'quick-order-modal',
                    buttons: []
                };

                $target.modal(options);

                $target.on('modalclosed', function () {
                    $('#quick-order-form').trigger('reset');
                });

                $(element).click(function() {
                    console.log(config.productName);
                    $target.modal('openModal');
                    $('#product-name').text(config.productName);
                });
            }
        };
        return {
            'quick-order-modal': ExampleModal.initModal
        };
    }
);
