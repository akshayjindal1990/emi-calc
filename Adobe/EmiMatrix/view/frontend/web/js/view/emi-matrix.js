define(
    [
        'jquery',
        'uiComponent',
        'Magento_Customer/js/customer-data',
        'Magento_Catalog/js/price-utils',
        'ko'
    ],
    function($, Component, customerData, priceUtils, ko) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Adobe_EmiMatrix/emi-matrix'
            },
            mutationObserver: window.MutationObserver || window.WebKitMutationObserver,
            reloadEmiMatrix: ko.observable([]),
            isVisible: ko.observable(true),
            /**
             * @inheritdoc
             * @param {JSON} config 
             */
            initialize: function(config) {
                this._super();
                var self = this;
                this.tenureUnit = this.constructor.defaults.tenureUnit;
                this.customerInfo = customerData.get('customer');
                this.emiMatrix = customerData.get('emi-matrix');
                customerData.get('emi-matrix').subscribe(function(event) {
                    if (event.items != undefined) {
                        self.isVisible(true);
                        self.fetchEmiMatrix();
                    }
                });
                this.spConfig = config.spConfig;
                this.productPrice = config.productPrice;
                this.tenureUnit = config.tenureUnit ? config.tenureUnit : 'm';
                this.configurableSelectionElement = '[name=selected_configurable_option]';
                this.fetchEmiMatrix();
                this.trackConfigurableSelectionChange(
                    $(this.configurableSelectionElement)[0]
                );
                $(this.configurableSelectionElement).on('change', function() {
                    self.fetchEmiMatrix();
                });
            },
            /**
             * Track mutation in the selected configuration for configurable product.
             * @param {*} element 
             */
            trackConfigurableSelectionChange: function(element) {
                var observer = new MutationObserver(function(mutations, observer) {
                    if (mutations[0].attributeName == "value") {
                        $(element).trigger("change");
                    }
                });
                observer.observe(element, {
                    attributes: true
                });
            },
            /**
             * Return pricing of the selected configuration product.
             * 
             * @returns {float}
             */
            getPrice: function() {
                if ($(this.configurableSelectionElement).val() != undefined) {
                    var selectedConfigurableOption = parseInt($(this.configurableSelectionElement).val());
                    if (selectedConfigurableOption > 0) {
                        this.productPrice = this.spConfig.optionPrices[selectedConfigurableOption].finalPrice.amount;
                    }
                }
                return this.productPrice;
            },

            /**
             * Load emiMatrixData
             * @return {JSON}
             */
            fetchEmiMatrix: function() {
                const result = [];
                const productPrice = this.getPrice();
                if (this.emiMatrix().items == undefined) {
                    this.isVisible(false);
                    return result;
                }
                this.emiMatrix().items.forEach(emi => {
                    var monthlyInterestRatio = emi.interest_rate / 1200;
                    var top = Math.pow((1 + monthlyInterestRatio), emi.tenure);
                    var bottom = top - 1;
                    var sp = top / bottom;
                    var emiMontly = ((productPrice * monthlyInterestRatio) * sp);
                    var totalAmount = emiMontly * emi.tenure;
                    var yearlyInteret = totalAmount - productPrice;
                    var perMonth = priceUtils.formatPrice(emiMontly);
                    var totalInterest = priceUtils.formatPrice(yearlyInteret);
                    result.push({
                        "emiPlan": perMonth + 'x' + emi.tenure + $.mage.__(this.tenureUnit),
                        "interest": totalInterest + '(' + emi.interest_rate + '%)',
                        "totalCost": priceUtils.formatPrice(totalAmount)
                    });
                });
                this.reloadEmiMatrix(result);
                return result;
            }
        });
    });