function processProduct() {
    $('.bxslider').bxSlider({
        minSlides: 1,
        maxSlides: 4,
        pager: false,
        moveSlides: 1,
        randomStart: true,
        infiniteLoop: true,
        moveSlides: 2,
        slideWidth: 240,
        slideMargin: 40
    });
    $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 210,
        itemMargin: 5,
        asNavFor: '#slider'
    });

    $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel"
    });
    $(".product-image").elevateZoom({
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500,
        zoomType: "inner",
        gallery: 'bx-pager',
        cursor: 'crosshair',
        galleryActiveClass: 'active'
    });

    $(".product-image").bind("click", function(e) {
        var ez = jQuery('.product-image').data('elevateZoom');
        jQuery.fancybox(ez.getGalleryList());
        return false;
    });
};
(function($) {
     processProduct();
    $.entwine('ugly', function($) {

        $('.product-form').entwine({

            onmatch: function() {
                var self = this;

                this.find('fieldset select').on('change', function(e) {

                    self._updatePrice(e);
                });
                self._updatePrice();

                this._super();
            },

            onunmatch: function() {
                this._super();
            },

            _updatePrice: function(e) {
                var self = this;
                var form = this.closest('form');

                //Get selected options
                var options = [];
                $('fieldset select', form).each(function() {
                    options.push($(this).val());
                });

                //Find the matching variation
                var variations = $.parseJSON($("input[name='DataMap']").val());
                for (var i = 0; i < variations.length; i++) {



                    var variationOptions = variations[i]['options'];

                    //If options arrays match update price
                    if ($(variationOptions).not(options).length == 0 && $(options).not(variationOptions).length == 0) {

                        $('.product-price-js').html(variations[i]['price']);
                        //add  linkproductId
                        $("#ProductForm_ProductForm_LinkProductID").val(variations[i]['LinkProductID']);
                        $.ajax({
                            type: "GET",
                            url: $('#linkproduct').val() + variations[i]['LinkProductID'],
                            success: function(data) {
                                if (data) {
                                    var _p = $.parseJSON(data);
                                    if (_p.image) {
                                        $('.slides').html(_p.image);
//                                        processProduct();
                                    }


                                }
                            }
                        });
                    }
                }
            }
        });

    });
}(jQuery));
