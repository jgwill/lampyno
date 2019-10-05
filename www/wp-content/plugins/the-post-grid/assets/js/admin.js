(function ($) {
    'use strict';

    if ($('#sc-tabs').length && $.fn.tabs) {
        $('#sc-tabs').tabs();
    }

    if ($.fn.select2) {
        $(".rt-select2").select2({dropdownAutoWidth: true});
    }
    var postType = jQuery("#rc-sc-post-type").val();
    rtTgpFilter();
    thpShowHideScMeta();
    renderTpgPreview();
    $("#rttpg_meta").on('change', 'select,input', function () {
        renderTpgPreview();
    });
    $("#rttpg_meta").on("input propertychange", function () {
        renderTpgPreview();
    });
    if ($("#rttpg_meta .rt-color").length && $.fn.wpColorPicker) {
        var cOptions = {
            defaultColor: false,
            change: function (event, ui) {
                renderTpgPreview();
            },
            clear: function () {
                renderTpgPreview();
            },
            hide: true,
            palettes: true
        };
        $("#rttpg_meta .rt-color").wpColorPicker(cOptions);
    }
    $(document).on('change', '#post_filter input[type=checkbox]', function () {
        var id = $(this).val();
        if (id == 'tpg_taxonomy') {
            if (this.checked) {
                rtTPGTaxonomyListByPostType(postType, $(this));
            } else {
                jQuery('.rt-tpg-filter.taxonomy > .taxonomy-field').hide('slow').html('');
                jQuery('.rt-tpg-filter.taxonomy > .rt-tpg-filter-item .term-filter-holder').hide('slow').html('');
                jQuery('.rt-tpg-filter.taxonomy > .rt-tpg-filter-item .term-filter-item-relation').hide('slow');
            }
        }
        if (this.checked) {
            $(".rt-tpg-filter." + id).show('slow');
        } else {
            $(".rt-tpg-filter." + id).hide('slow');
        }

    });

    $(document).on('change', '#post-taxonomy input[type=checkbox]', function () {
        thpShowHideScMeta();
        rtTPGTermListByTaxonomy($(this));
    });

    $(document).on('change', "#rt-tpg-pagination", function () {
        if (this.checked) {
            jQuery(".field-holder.posts-per-page").show();
        } else {
            jQuery(".field-holder.posts-per-page").hide();
        }
    });

    $(document).on('change', "#rt-feature-image", function () {
        if (this.checked) {
            jQuery(".field-holder.feature-image-options").hide();
        } else {
            jQuery(".field-holder.feature-image-options").show();
        }
    });

    $("#rt-tpg-sc-layout").on("change", function (e) {
        thpShowHideScMeta();
    });

    $("#rc-sc-post-type").on("change", function (e) {
        postType = $(this).select2("val");
        if (postType) {
            rtTPGIsotopeFilter($(this));
            $('#post_filter input[type=checkbox]').each(function () {
                $(this).prop('checked', false);
            });
            $(".rt-tpg-filter.taxonomy > .taxonomy-field").html('');
            $(".rt-tpg-filter.taxonomy > .rt-tpg-filter-item .term-filter-item-container").remove();
            $(".rt-tpg-filter.hidden").hide();
            $(".field-holder.term-filter-item-relation ").hide();
        }
    });


    function renderTpgPreview() {
        if ($("#rttpg_meta").length) {
            var data = $("#rttpg_meta").find('input[name],select[name],textarea[name]').serialize(),
                container = $("#tpg-preview-container").find('.rt-tpg-container'),
                loader = container.find(".rt-content-loader");
            // Add Shortcode ID
            data = data + '&' + $.param({'sc_id': $('#post_ID').val() || 0});
            $(".rt-response")
                .addClass('loading')
                .html('<span>Loading...</span>');
            tpgAjaxCall(null, 'tpgPreviewAjaxCall', data, function (data) {
                if (!data.error) {
                    $("#tpg-preview-container").html(data.data);
                    initTpg();
                    loader.find('.rt-loading-overlay, .rt-loading').remove();
                    loader.removeClass('tpg-pre-loader');
                }
                $(".rt-response").removeClass('loading').html('');
            });
        }
    }

    function tpgAjaxCall(element, action, arg, handle) {
        var data;
        if (action) data = "action=" + action;
        if (arg) data = arg + "&action=" + action;
        if (arg && !action) data = arg;

        var n = data.search(rttpg.nonceID);
        if (n < 0) {
            data = data + "&rttpg_nonce=" + rttpg.nonce;
        }
        $.ajax({
            type: "post",
            url: rttpg.ajaxurl,
            data: data,
            beforeSend: function () {
                if (element) {
                    $("<span class='rt-loading'></span>").insertAfter(element);
                }
            },
            success: function (data) {
                if (element) {
                    element.next(".rt-loading").remove();
                }
                handle(data);
            }
        });
    }

})(jQuery);

function rtTPGTaxonomyListByPostType(postType, $this) {

    var arg = "post_type=" + postType;
    tpgAjaxCall($this, 'rtTPGTaxonomyListByPostType', arg, function (data) {
        //console.log(data);
        if (data.error) {
            alert(data.msg);
        } else {
            jQuery('.rt-tpg-filter.taxonomy > .taxonomy-field').html(data.data).show('slow');
        }
    });
}

function rtTPGIsotopeFilter($this) {
    var arg = "post_type=" + $this.val();
    var bindElement = $this;
    var target = jQuery('.field-holder.sc-isotope-filter .field > select');
    tpgAjaxCall(bindElement, 'rtTPGIsotopeFilter', arg, function (data) {
        if (data.error) {
            alert(data.msg);
        } else {
            target.html(data.data);
            tgpLiveReloadScript();
        }
    });
}

function rtTPGTermListByTaxonomy($this) {
    var term = $this.val();
    var targetHolder = jQuery('.rt-tpg-filter.taxonomy').children('.rt-tpg-filter-item').children('.field-holder').children('.term-filter-holder');
    var target = targetHolder.children('.term-filter-item-container.' + term);
    if ($this.is(':checked')) {
        var arg = "taxonomy=" + $this.val();
        var bindElement = $this;
        tpgAjaxCall(bindElement, 'rtTPGTermListByTaxonomy', arg, function (data) {
            //console.log(data);
            if (data.error) {
                alert(data.msg);
            } else {
                targetHolder.show();
                jQuery(data.data).prependTo(targetHolder).fadeIn('slow');
                tgpLiveReloadScript();
            }
        });
    } else {
        target.hide('slow').html('').remove();
    }

    var termLength = jQuery('input[name="tpg_taxonomy[]"]:checked').length;
    if (termLength > 1) {
        jQuery('.field-holder.term-filter-item-relation ').show('slow');
    } else {
        jQuery('.field-holder.term-filter-item-relation ').hide('slow');
    }

}

function rtTPGSettings(e) {
    jQuery('rt-response').hide();
    var arg = jQuery(e).serialize();
    var bindElement = jQuery('.rtSaveButton');
    tpgAjaxCall(bindElement, 'rtTPGSettings', arg, function (data) {
        if (data.error) {
            jQuery('.rt-response').addClass('updated');
            jQuery('.rt-response').removeClass('error');
            jQuery('.rt-response').show('slow').text(data.msg);
        } else {
            jQuery('.rt-response').addClass('error');
            jQuery('.rt-response').show('slow').text(data.msg);
        }
    });

}


function tpgAjaxCall(element, action, arg, handle) {
    var data;
    if (action) data = "action=" + action;
    if (arg) data = arg + "&action=" + action;
    if (arg && !action) data = arg;

    var n = data.search(rttpg.nonceID);
    if (n < 0) {
        data = data + "&rttpg_nonce=" + rttpg.nonce;
    }
    jQuery.ajax({
        type: "post",
        url: rttpg.ajaxurl,
        data: data,
        beforeSend: function () {
            jQuery("<span class='rt-loading'></span>").insertAfter(element);
        },
        success: function (data) {
            jQuery(".rt-loading").remove();
            handle(data);
        }
    });
}

function rtTgpFilter() {
    jQuery("#post_filter input[type=checkbox]:checked").each(function () {
        var id = jQuery(this).val();
        jQuery(".rt-tpg-filter." + id).show();
    });

    jQuery("#post-taxonomy input[type=checkbox]:checked").each(function () {
        var id = jQuery(this).val();
        jQuery(".filter-item." + id).show();
    });

}

function thpShowHideScMeta() {

    var layout = jQuery("#rt-tpg-sc-layout").val();
    if (layout == 'isotope1') {
        jQuery(".field-holder.pagination, .field-holder.posts-per-page").hide();
        jQuery(".field-holder.sc-isotope-filter").show();
    } else {
        jQuery(".field-holder.pagination").show();
        jQuery(".field-holder.sc-isotope-filter").hide();
        var pagination = jQuery("#rt-tpg-pagination").is(':checked');
        if (pagination) {
            jQuery(".field-holder.posts-per-page").show();
        } else {
            jQuery(".field-holder.posts-per-page").hide();
        }
    }
    if (layout == 'layout2' || layout == 'layout3') {
        jQuery('.holder-layout2-image-column').show();
    } else {
        jQuery('.holder-layout2-image-column').hide();
    }
    if (jQuery("#post-taxonomy input[name='tpg_taxonomy[]']").is(":checked")) {
        jQuery(".rt-tpg-filter-item.term-filter-item").show();
    } else {
        jQuery(".rt-tpg-filter-item.term-filter-item").hide();
    }


    if (jQuery("#rt-feature-image").is(':checked')) {
        jQuery(".field-holder.feature-image-options").hide();
    } else {
        jQuery(".field-holder.feature-image-options").show();
    }

}

function tgpLiveReloadScript() {
    jQuery("select.rt-select2").select2({dropdownAutoWidth: true});
}