document.observe("dom:loaded", function () {
    var targetElements = 'a.alert-price, a.link-wishlist, a.link-share, #product_addtocart_form';
    var addToCartForm = $('product_addtocart_form');

    if ('undefined' != typeof(amQuickviewIsRedirect) && amQuickviewIsRedirect == '1') {
        addToCartForm.insert("<input type='hidden' name='in_cart' value='" + amQuickviewIsRedirect + "'>");
    } else {
        addToCartForm.insert("<input type='hidden' name='return_url' value='" + parent.location.href + "'>");
    }

    $$(targetElements).each(function (link) {
        link.writeAttribute('target', '_parent');
        link.writeAttribute('onclick', '');
        link.onclick = "";
        jQuery(link).removeAttr("onclick");
    });
});
