<?php if(
    request()->routeIs('shop.checkout.onepage.index')
    && (bool) core()->getConfigData('sales.payment_methods.paypal_smart_button.active')
): ?>
    <?php
        $clientId = core()->getConfigData('sales.payment_methods.paypal_smart_button.client_id');

        $acceptedCurrency = core()->getConfigData('sales.payment_methods.paypal_smart_button.accepted_currencies');

        $currentCurrency = core()->getCurrentCurrencyCode();

        $acceptedCurrenciesArray = array_map('trim', explode(',', $acceptedCurrency));

        $currencyToUse = in_array($currentCurrency, $acceptedCurrenciesArray)
            ? $currentCurrency
            : $acceptedCurrenciesArray[0];
    ?>

    <?php if (! $__env->hasRenderedOnce('ccdbc04f-28f6-4ae4-bb37-5e0ecfa156b7')): $__env->markAsRenderedOnce('ccdbc04f-28f6-4ae4-bb37-5e0ecfa156b7');
$__env->startPush('scripts'); ?>
        <script
            src="https://www.paypal.com/sdk/js?client-id=<?php echo e($clientId); ?>&currency=<?php echo e($currencyToUse); ?>"
            data-partner-attribution-id="Bagisto_Cart"
        >
        </script>

        <script
            type="text/x-template"
            id="v-paypal-smart-button-template"
        >
            <div class="w-full paypal-button-container"></div>
        </script>

        <script type="module">
            app.component('v-paypal-smart-button', {
                template: '#v-paypal-smart-button-template',

                mounted() {
                    this.register();
                },

                methods: {
                    register() {
                        if (typeof paypal == 'undefined') {
                            this.$emitter.emit('add-flash', { type: 'error', message: '<?php echo app('translator')->get('Something went wrong.'); ?>' });

                            return;
                        }

                        paypal.Buttons(this.getOptions()).render('.paypal-button-container');
                    },

                    getOptions() {
                        let options = {
                            style: {
                                layout: 'vertical',
                                shape: 'rect',
                            },

                            authorizationFailed: false,

                            enableStandardCardFields: false,

                            alertBox: (message) => {
                                this.$emitter.emit('add-flash', { type: 'error', message: message });
                            },

                            createOrder: (data, actions) => {
                                return this.$axios.get("<?php echo e(route('paypal.smart-button.create-order')); ?>")
                                    .then(response => response.data.result)
                                    .then(order => order.id)
                                    .catch(error => {
                                        if (error.response.data.error === 'invalid_client') {
                                            options.authorizationFailed = true;

                                            options.alertBox('<?php echo app('translator')->get('Something went wrong.'); ?>');
                                        }

                                        return error;
                                    });
                            },

                            onApprove: (data, actions) => {
                                this.$axios.post("<?php echo e(route('paypal.smart-button.capture-order')); ?>", {
                                    _token: "<?php echo e(csrf_token()); ?>",
                                    orderData: data
                                })
                                .then(response => {
                                    if (response.data.success) {
                                        if (response.data.redirect_url) {
                                            window.location.href = response.data.redirect_url;
                                        } else {
                                            window.location.href = "<?php echo e(route('shop.checkout.onepage.success')); ?>";
                                        }
                                    }
                                })
                                .catch(error => window.location.href = "<?php echo e(route('shop.checkout.cart.index')); ?>");
                            },

                            onError: (error) => {
                                if (! options.authorizationFailed) {
                                    options.alertBox('<?php echo app('translator')->get('Something went wrong.'); ?>');
                                }
                            },
                        };

                        return options;
                    },
                },
            });
        </script>
    <?php $__env->stopPush(); endif; ?>
<?php endif; ?>
<?php /**PATH /var/www/html/emart/packages/Webkul/Paypal/src/Providers/../Resources/views/checkout/onepage/paypal-smart-button.blade.php ENDPATH**/ ?>