
/**
 * Advanced Permissions
 *
 * @category:    Aitoc
 * @package:     Aitoc_Aitpermissions
 * @version      2.9.3
 * @license:     n/a
 * @copyright:   Copyright (c) 2014 AITOC, Inc. (http://www.aitoc.com)
 */
function toggleApplyVisibility(select) {
    if ($(select).value == 1) {
        $(select).next('select').removeClassName('no-display');
        $(select).next('select').removeClassName('ignore-validate');

    } else {
        $(select).next('select').addClassName('no-display');
        $(select).next('select').addClassName('ignore-validate');
        var options = $(select).next('select').options;
        for( var i=0; i < options.length; i++) {
            options[i].selected = false;
        }
    }
}