define([
    'jquery',
    'mage/utils/wrapper'
], function($, wrapper) {
    'use strict';
    return function(targetModule) {
        var reloadPrice = targetModule.prototype._reloadPrice;
        var reloadPriceWrapper = wrapper.wrap(reloadPrice, function(original) {
            var result = original();

            if(this.simpleProduct && null !== this.options.spConfig.ingredientsLabels[this.simpleProduct]) {
                $('#ingredients_label .label_image')
                    .attr('src', this.options.spConfig.ingredientsLabels[this.simpleProduct])
                    .show();
                $('#ingredients_label .message').hide();
            } else {
                $('#ingredients_label .label_image').hide();
                $('#ingredients_label .message').show();
            }

            return result;
        });

        targetModule.prototype._reloadPrice = reloadPriceWrapper;
        return targetModule;
    };
});
