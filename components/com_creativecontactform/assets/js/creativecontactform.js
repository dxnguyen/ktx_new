(function ($) {
    $(document).ready(function () {
        function ccf_set_sc_res() {
            var a = window.screen.width, screenHeight = window.screen.height;
            var b = a + 'X' + screenHeight;
            $('.ccf_sc_res').val(b)
        }

        ccf_set_sc_res();
        $.fn.shake = function (a) {
            var b = {'shakes': 3, 'distance': 10, 'duration': 300};
            if (a) {
                $.extend(b, a)
            }
            ;var c;
            return this.each(function () {
                $this = $(this);
                c = $this.css('position');
                if (!c || c === 'static') {
                    $this.css('position', 'relative')
                }
                ;
                for (var x = 1; x <= b.shakes; x++) {
                    $this.animate({left: b.distance * -1}, (b.duration / b.shakes) / 4).animate({left: b.distance}, (b.duration / b.shakes) / 2).animate({left: 0}, (b.duration / b.shakes) / 4)
                }
            })
        };

        function validate_name(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val());
            if ((!c && d == '') || d.length > 0) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_address(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val());
            if ((!c && d == '') || d.length > 0) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_simple_text(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val());
            if ((!c && d == '') || d.length > 0) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_datepicker(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val());
            if ((!c && d == '') || d.length > 0) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_text_area(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val());
            if ((!c && d == '') || d.length > 0) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_email(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val());
            var i = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(d);
            if ((!c && d == '') || i) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_phone(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val());
            var i = /^[0-9\-\(\)\_\:\+ ]+$/i.test(d);
            if ((!c && d == '') || i) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_number(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val());
            var i = /^[0-9]+$/i.test(d);
            if ((!c && d == '') || i) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_url(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val());
            var i = /^(((ht|f){1}(tp:[/][/]){1})|((www.){1}))[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+$/i.test(d);
            if ((!c && d == '') || i) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_select(b, c) {
            var d = b.hasClass('creativecontactform_required') ? true : false;
            b.prev('select').addClass('sss');
            var e = '';
            b.prev('select').find('option').each(function () {
                var a = $(this).attr('selected');
                if (a == 'selected') e = $(this).val()
            });
            if (!d || e != 'creative_empty') b.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                b.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (c) {
                    var f = b.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var g = creativecontactform_shake_count_array[f];
                    var h = creativecontactform_shake_distanse_array[f];
                    var i = creativecontactform_shake_duration_array[f];
                    b.shake({'shakes': g, 'distance': h, 'duration': i})
                }
            }
            create_validation_effects(b.parents('.creativecontactform_wrapper'))
        };

        function validate_multiple_select(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = a.prev('select').find('option:first-child').attr("selected");
            var e = d == 'selected' ? false : true;
            if (!c || e) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var f = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var g = creativecontactform_shake_count_array[f];
                    var h = creativecontactform_shake_distanse_array[f];
                    var i = creativecontactform_shake_duration_array[f];
                    a.shake({'shakes': g, 'distance': h, 'duration': i})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_radio(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = 0;
            a.find('input.creative_ch_r_element').each(function () {
                if ($(this).prop('checked') == true) d++
            });
            if (!c || d == 1) a.removeClass('creativecontactform_error'); else {
                a.addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.find('.answer_input').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_checkbox(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = 0;
            a.find('input.creative_ch_r_element').each(function () {
                if ($(this).prop('checked') == true) d++
            });
            if (!c || d >= 1) a.removeClass('creativecontactform_error'); else {
                a.addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.find('.answer_input').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_file_upload(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = a.find('.creative_active_upload').length;
            if (!c || d >= 1) a.removeClass('creativecontactform_error'); else {
                a.addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.find('.creative_fileupload').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_captcha(a, b) {
            var c = a.hasClass('creativecontactform_required') ? true : false;
            var d = $.trim(a.val()).length;
            if (!c || d >= 3) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var e = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var f = creativecontactform_shake_count_array[e];
                    var g = creativecontactform_shake_distanse_array[e];
                    var h = creativecontactform_shake_duration_array[e];
                    a.parents('.creativecontactform_input_element').shake({'shakes': f, 'distance': g, 'duration': h})
                }
            }
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };

        function validate_ccf_recaptcha(a, b) {
            var c = parseInt(a.val());
            if (c == 1) a.parents('.creativecontactform_field_box').removeClass('creativecontactform_error'); else {
                a.parents('.creativecontactform_field_box').addClass('creativecontactform_error');
                if (b) {
                    var d = a.parents('.creativecontactform_wrapper').find(".creativecontactform_send").attr("roll");
                    var e = creativecontactform_shake_count_array[d];
                    var f = creativecontactform_shake_distanse_array[d];
                    var g = creativecontactform_shake_duration_array[d];
                    a.prev('.ccf_recaptcha_wrapper').shake({'shakes': e, 'distance': f, 'duration': g})
                }
            }
        };

        function creativecontactform_make_validation(a) {
            a.parents('.creativecontactform_wrapper').find(".creative_name").each(function () {
                validate_name($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_email").each(function () {
                validate_email($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_address").each(function () {
                validate_address($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_text-input").each(function () {
                validate_simple_text($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_phone").each(function () {
                validate_phone($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_text-area").each(function () {
                validate_text_area($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_number").each(function () {
                validate_number($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_url").each(function () {
                validate_url($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".single_select").each(function () {
                validate_select($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".multiple_select").each(function () {
                validate_multiple_select($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_radio").each(function () {
                validate_radio($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_checkbox").each(function () {
                validate_checkbox($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find(".creative_file-upload").each(function () {
                validate_file_upload($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find("input.creative_captcha").each(function () {
                validate_captcha($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find("input.ccf_recaptcha").each(function () {
                validate_ccf_recaptcha($(this), true)
            });
            a.parents('.creativecontactform_wrapper').find("input.creative_datepicker").each(function () {
                validate_datepicker($(this), true)
            });
            create_validation_effects(a.parents('.creativecontactform_wrapper'))
        };$('.creativecontactform_send').click(function () {
            var d = $(this).attr("roll");
            if (!check_pro_version($(this).parents('.creativecontactform_wrapper'))) {
                return false
            }
            ;var e = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_loading_wrapper');
            var f = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_pre_text');
            var g = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_send');
            var h = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_send_new');
            var j = $(this).parents('.creativecontactform_wrapper').find('.creative_captcha_info').html();
            $wrapper_element = $(this).parents('.creativecontactform_wrapper');
            var k = 'Error validating reCAPTCHA';
            var m = $(this).parents('.creativecontactform_wrapper').find('.reload_creative_captcha');
            creativecontactform_make_validation($(this));
            var n = parseInt($(this).parents('.creativecontactform_wrapper').find('.creativecontactform_error').length);
            if (n != 0) {
                var o = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_error:first').find('input');
                o.addClass('mouseentered');
                o.focus();
                setTimeout(function () {
                    o.trigger('mousedown')
                }, 500)
            } else {
                animate_loading_start(e);
                var p = $(this).parents('form').serialize();
                var q = creativecontactform_path.replace("/components/com_creativecontactform/", "");
                $.ajax({
                    url: q + '/index.php?option=com_creativecontactform&view=creativemailer&format=raw',
                    type: "post",
                    data: p,
                    dataType: "json",
                    success: function (a) {
                        if (a[0].invalid == 'invalid_token') {
                            ccf_make_alert('Invalid Token', 'creative_error', d);
                            animate_loading_end(e);
                            return
                        } else if (a[0].invalid == 'invalid_captcha') {
                            ccf_make_alert(j, 'creative_error', d);
                            m.trigger('click');
                            animate_loading_end(e);
                            return
                        } else if (a[0].invalid == 'invalid_recaptcha') {
                            ccf_make_alert(k, 'creative_error', d);
                            animate_loading_end(e);
                            var b = $wrapper_element.find('.creative_timing_google-recaptcha').attr("rcp_id");
                            grecaptcha.reset(b);
                            $wrapper_element.find('.ccf_recaptcha').val("0");
                            return
                        } else if (a[0].invalid == 'problem_sending_email') {
                            ccf_make_alert('Could not instantiate mail function.', 'creative_error', d);
                            animate_loading_end(e);
                            return
                        }
                        ;animate_loading_end(e);
                        h.removeClass('creativecontactform_hidden');
                        g.addClass('creativecontactform_hidden');
                        if (creativecontactform_thank_you_text_array[d] != '') {
                            ccf_make_alert(creativecontactform_thank_you_text_array[d], 'creative_success', d)
                        }
                        ;var l = a[0].info.length;
                        for (var i = 0; i <= l; i++) {
                            if (a[0].info[i] != undefined) console.log(a[0].info[i])
                        }
                        ;
                        if (creativecontactform_redirect_enable_array[d] == 1) {
                            if (creativecontactform_redirect_array[d] != '') {
                                setTimeout(function () {
                                    window.location.href = creativecontactform_redirect_array[d]
                                }, parseInt(creativecontactform_redirect_delay_array[d]))
                            }
                        }
                    },
                    error: function (a, b, c) {
                        console.log(a.responseText);
                        ccf_make_alert('Server error', 'creative_error', d);
                        animate_loading_end(e)
                    }
                })
            }
        });
        $('.creativecontactform_send_new').click(function () {
            var j = $(this).attr("roll");
            var k = $(this).parents('.creativecontactform_wrapper');
            var l = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_loading_wrapper');
            var m = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_pre_text');
            var n = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_field_box');
            var o = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_send');
            var p = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_send_new');
            var q = $(this).parents('.creativecontactform_wrapper').find('.creative_input_reset');
            var r = $(this).parents('.creativecontactform_wrapper').find('.creative_textarea_reset');
            var s = $(this).parents('.creativecontactform_wrapper').find('.reload_creative_captcha');
            var t = creativecontactform_path.replace("/components/com_creativecontactform/", "");
            animate_loading_start(l);
            $.ajax({
                url: t + '/index.php?option=com_creativecontactform&view=creativemailer&format=raw',
                type: "get",
                data: 'get_token=1',
                success: function (e) {
                    animate_loading_end(l);
                    $('.creativecontactform_token').attr("name", e);
                    p.addClass('creativecontactform_hidden');
                    o.removeClass('creativecontactform_hidden');
                    q.val('');
                    r.val('');
                    k.find('.creative_name').each(function () {
                        var a = $(this).attr("pre_value");
                        if (a != '') $(this).val(a)
                    });
                    k.find('.creative_email').each(function () {
                        var a = $(this).attr("pre_value");
                        if (a != '') $(this).val(a)
                    });
                    setTimeout(function () {
                        k.find('.creativecontactform_error').removeClass('creativecontactform_error')
                    }, 150);
                    var f = Array();
                    k.find('.creativeform_twoglux_styled').each(function () {
                        var a = $(this);
                        var b = a.attr("id");
                        var c = a.attr("pre_val");
                        var d = 'creativeform_twoglux_styled_' + b;
                        if (c == 'checked') f.push(d);
                        a.prop("checked", false)
                    });
                    k.find('.creativeform_twoglux_styled_checkbox.twoglux_checked').each(function () {
                        $(this).trigger("mousedown");
                        $(this).trigger("mouseup")
                    });
                    k.find('.creativeform_twoglux_styled_radio.twoglux_checked').each(function () {
                        $(this).removeClass('twoglux_checked').find('.radio_part1').css('opacity', 0)
                    });
                    setTimeout(function () {
                        for (tt in f) {
                            var a = f[tt];
                            if (typeof (a) !== "function") {
                                $("#" + a).trigger("mousedown");
                                $("#" + a).trigger("mouseup")
                            }
                        }
                    }, 100);
                    var g = Array();
                    k.find('.will_be_creative_select').each(function () {
                        var d = $(this);
                        d.find('option').each(function (i) {
                            var a = $(this);
                            var b = a.attr("id");
                            var c = a.attr('pre_val');
                            if (c == 'selected') g.push(b)
                        })
                    });
                    setTimeout(function () {
                        for (var a in g) {
                            if (typeof (g[a]) !== "function") {
                                $("#sel_" + g[a]).trigger("click")
                            }
                        }
                    }, 100);
                    k.find('.ccf_close_icon').each(function () {
                        U = false;
                        $(this).parents('.creative_select').prev('select').find('option').removeAttr('selected');
                        $(this).parents('.creative_select').prev('select').find('.def_value').attr('selected', 'selected');
                        var a = $(this).parents('.creative_select').prev('select').find('.def_value').html();
                        $(this).parents('.creative_select').find('.creative_selected_option').html(a);
                        $(this).parents('.creative_select').find('.creative_select_option').removeClass('selected');
                        $(this).hide()
                    });
                    k.find('.multiple_select.creative_select').each(function () {
                        $(this).prev('select').find('option').removeAttr('selected');
                        $(this).prev('select').find('.def_value').attr('selected', 'selected');
                        var a = $(this).prev('select').find('.def_value').html();
                        $(this).find('.creative_selected_option').html(a)
                    });
                    k.find('.creative_search_input').each(function () {
                        $(this).val('').trigger('keyup')
                    });
                    k.find('.creative_uploaded_files').html('');
                    k.find('.reload_creative_captcha').trigger('click');
                    if (k.find('.ccf_recaptcha').val() == 1) {
                        k.find('.ccf_recaptcha').val("0");
                        var h = k.find('.creative_timing_google-recaptcha').attr("rcp_id");
                        grecaptcha.reset(h)
                    }
                },
                error: function () {
                    ccf_make_alert('Error', 'creative_error', j);
                    s.trigger('click');
                    animate_loading_end(l)
                }
            })
        });

        function animate_loading_start(a) {
            a.css({opacity: 0, display: 'block'}).stop().animate({opacity: 1}, 400)
        };

        function animate_loading_end(a) {
            a.stop().animate({opacity: 0}, 400, function () {
                $(this).hide()
            })
        };$(".creative_name").blur(function () {
            validate_name($(this), false)
        });
        $(".creative_datepicker").blur(function () {
        });
        $(".creative_email").blur(function () {
            validate_email($(this), false)
        });
        $(".creative_address").blur(function () {
            validate_address($(this), false)
        });
        $(".creative_text-input").blur(function () {
            validate_simple_text($(this), false)
        });
        $(".creative_phone").blur(function () {
            validate_phone($(this), false)
        });
        $(".creative_text-area").blur(function () {
            validate_text_area($(this), false)
        });
        $(".creative_number").blur(function () {
            validate_number($(this), false)
        });
        $(".creative_url").blur(function () {
            validate_url($(this), false)
        });
        $("input.creative_captcha").blur(function () {
            validate_captcha($(this), false)
        });
        $('.creativecontactform_input_element input,.creativecontactform_input_element textarea').focus(function () {
            $(this).parents('.creativecontactform_input_element').addClass('focused')
        });
        $('.creativecontactform_input_element input,.creativecontactform_input_element textarea').blur(function () {
            $(this).parents('.creativecontactform_input_element').removeClass('focused')
        });
        var O = Array();
        $('.creativeform_twoglux_styled').each(function () {
            var a = $(this);
            var b = a.attr("type");
            var c = a.attr("data-color");
            var d = a.attr("name");
            var e = a.attr("id");
            var f = a.attr("uniq_index");
            var g = a.attr("pre_val");
            var h = 'creativeform_twoglux_styled_' + e;
            if (g == 'checked') O.push(h);
            a.wrap('<div class="creativeform_twoglux_styled_input_wrapper" />');
            if (b == 'radio') var i = '<div class="radio_part1 ' + c + '_radio_part1 unselectable" >&nbsp;</div>'; else var i = '<div class="checkbox_part1 ' + c + '_checkbox_part1 unselectable" >&nbsp;</div><div class="checkbox_part2 ' + c + '_checkbox_part2 unselectable">&nbsp;</div>';
            var j = '<a id="' + h + '" class="creativeform_twoglux_styled_element creativeform_twoglux_styled_' + c + ' creativeform_twoglux_styled_' + b + ' unselectable a_' + f + '">' + i + '</a>';
            a.after(j);
            a.hide()
        });
        setTimeout(function () {
            for (tt in O) {
                var a = O[tt];
                if (typeof (a) !== "function") {
                    $("#" + a).trigger("mousedown");
                    $("#" + a).trigger("mouseup")
                }
            }
        }, 200);
        $('.creativeform_twoglux_styled_element').on('mouseenter', function () {
            make_mouseenter($(this))
        });
        $('.creativeform_twoglux_styled_element').on('mouseleave', function () {
            make_mouseleave($(this))
        });

        function make_mouseenter(a) {
            if (a.hasClass('creativeform_twoglux_styled_radio')) a.addClass('creativeform_twoglux_styled_radio_hovered'); else a.addClass('creativeform_twoglux_styled_checkbox_hovered')
        };

        function make_mouseleave(a) {
            if (a.hasClass('creativeform_twoglux_styled_radio')) a.removeClass('creativeform_twoglux_styled_radio_hovered'); else a.removeClass('creativeform_twoglux_styled_checkbox_hovered')
        };var P = 200;
        var Q = 'up';
        var R = 'up';
        var S = false;

        function animate_checkbox1_down(a) {
            a.animate({height: 9}, P)
        };

        function animate_checkbox1_up(a) {
            a.parent('a').removeClass('twoglux_checked');
            a.parent('a').prev('input').prop("checked", false);
            a.animate({height: 0}, P)
        };

        function animate_checkbox2_up(a) {
            a.animate({height: 12}, P);
            a.parent('a').addClass('twoglux_checked');
            a.parent('a').prev('input').prop("checked", true)
        };

        function animate_checkbox2_down(a) {
            a.animate({height: 0}, P)
        };$('.creativeform_twoglux_styled_checkbox').on('mousedown', function () {
            if ($(this).hasClass('twoglux_checked')) animate_checkbox2_down($(this).find('.checkbox_part2')); else animate_checkbox1_down($(this).find('.checkbox_part1'));
            Q = 'down';
            S = true
        });
        $('.creativeform_twoglux_styled_checkbox').on('mouseup', function () {
            if (Q == 'down') {
                if ($(this).hasClass('twoglux_checked')) animate_checkbox1_up($(this).find('.checkbox_part1')); else animate_checkbox2_up($(this).find('.checkbox_part2'))
            }
            Q = 'up';
            S = false;
            validate_checkbox($(this).parents('.creative_checkbox'), false)
        });
        $('.radio_part1').css('opacity', '0');
        $('.creativeform_twoglux_styled_radio').on('mousedown', function () {
            if (!($(this).hasClass('twoglux_checked'))) {
                $(this).find('.radio_part1').fadeTo(P, 0.5)
            }
            R = 'down';
            S = true
        });
        $('.creativeform_twoglux_styled_radio').on('mouseup', function () {
            if (R == 'down') {
                if (!($(this).hasClass('twoglux_checked'))) {
                    $(this).addClass('twoglux_checked');
                    var a = $(this).prev('input').attr("uniq_index");
                    $('.' + a).prop("checked", false);
                    $(this).prev('input').prop("checked", true);
                    var b = $(this).prev('input').val();
                    var c = $(this).prev('input').attr("name");
                    c = c.replace('remove_this_part', '');
                    $(this).parents('.creative_radio').find('.bug_fixer').remove();
                    var d = '<input class="bug_fixer" type="hidden" name="' + c + '" value="' + b + '" />';
                    $(this).parents('.creative_radio').find('.creativecontactform_field_name').after(d);
                    $('.a_' + a).removeClass('twoglux_checked');
                    $(this).addClass('twoglux_checked');
                    $('.a_' + a).not($(this)).find('.radio_part1').fadeTo(P, 0);
                    $(this).find('.radio_part1').fadeTo(P, 1)
                }
            }
            ;R = 'up';
            S = false;
            validate_radio($(this).parents('.creativecontactform_field_box'), false)
        });
        $('.creativeform_twoglux_styled_input_wrapper').bind("dragstart", function () {
            return false
        });
        $("body").on('mouseup', function () {
            if (S) {
                var a = $('.creativeform_twoglux_styled_element').not('.twoglux_checked').find('.checkbox_part1');
                animate_checkbox1_up(a);
                var a = $('.creativeform_twoglux_styled_element.twoglux_checked').find('.checkbox_part2');
                animate_checkbox2_up(a);
                var a = $('.creativeform_twoglux_styled_element').not('.twoglux_checked').find('.radio_part1');
                a.fadeTo(P, 0)
            }
        });
        $('.twoglux_label').on('mouseenter', function () {
            var a = $(this).attr("uniq_index");
            make_mouseenter($("#creativeform_twoglux_styled_" + a))
        });
        $('.twoglux_label').on('mouseleave', function () {
            var a = $(this).attr("uniq_index");
            make_mouseleave($("#creativeform_twoglux_styled_" + a))
        });
        $('.twoglux_label').on('mousedown', function (e) {
            if ($(e.target).hasClass('ccf_popup_link')) return;
            var a = $(this).attr("uniq_index");
            $("#creativeform_twoglux_styled_" + a).trigger("mousedown")
        });
        $('.twoglux_label').on('mouseup', function (e) {
            if ($(e.target).hasClass('ccf_popup_link')) return;
            var a = $(this).attr("uniq_index");
            $("#creativeform_twoglux_styled_" + a).trigger("mouseup")
        });
        var T = Array();
        $('.will_be_creative_select').each(function () {
            var f = $(this);
            var g = f.attr("multiple");
            var h = '';
            var j = $(this).hasClass("creativecontactform_required") ? 'creativecontactform_required' : '';
            var k = f.attr("special_width");
            var l = k != '' ? 'style="width: ' + k + ' !important"' : '';
            var m = f.attr("select_no_match_text");
            var n = f.attr("show_search") == 'show' ? '' : 'style="display: none"';
            var o = parseInt(f.attr("scroll_after"));
            var p = g == 'multiple' ? 'multiple_select' : 'single_select';
            var q = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_send').attr('roll');
            var r = '<div class="creative_options_wrapper wrapper_of_' + p + '"><div ' + n + ' class="creative_search"><input class="creative_search_input" type="text" value="" /><span class="creative_search_icon">&nbsp;</span></div><div class="creative_scrollbar creative_scoll_inner_wrapper"><div class="creative_scrollbar_mask creative_scroll_inner"><div class="creative_select_empty_option do_not_hide_onclcik">' + m + ' "<span class="do_not_hide_onclcik"></span>"</div>';
            f.find('option').each(function (i) {
                var a = $(this);
                var b = a.html();
                var c = a.attr("id");
                var d = a.val();
                if (d == 'creative_empty') h = b;
                if (d != 'creative_empty') r += '<div id="sel_' + c + '" opt_id="' + c + '" class="creative_select_option option_of_' + p + '"><span class="creative_option_state wrapper_of_' + p + '">&nbsp;</span><span class="creative_opt_value wrapper_of_' + p + '">' + b + '</span></div>';
                var e = a.attr('selected');
                if (e == 'selected') T.push(c)
            });
            r += '</div><div class="creative_scrollbar_draggable"><a href="#" class="draggable"></a></div><div class="creative_clear"></div></div></div>';
            var s = '<div class="creative_select creativecontactform_input_element ' + p + ' ' + j + '"><div class="ccf_select_icon closed"></div><div class="ccf_close_icon"></div><div class="creative_input_dummy_wrapper creative_selected_option">' + h + '</div>' + r + '</div>';
            f.after(s);
            f.hide()
        });
        setTimeout(function () {
            $(".creativecontactform_wrapper").each(function () {
                var a = $(this).attr("scrollbar_popup_style");
                var b = $(this).attr("scrollbar_content_style");
                $(".creative_scrollbar").mCustomScrollbar({
                    mouseWheel: {enable: true},
                    scrollButtons: {enable: true},
                    theme: a
                });
                $(".creative_content_scrollbar").mCustomScrollbar({
                    mouseWheel: {enable: true},
                    scrollButtons: {enable: true},
                    theme: b
                })
            })
        }, 150);
        setTimeout(function () {
            $('.creative_select').each(function () {
                generate_max_height($(this))
            })
        }, 50);

        function generate_max_height(a) {
            var b = parseInt(a.prev('select').attr("scroll_after"));
            a.find('.creative_options_wrapper').css({'visibility': 'hidden', 'display': 'block'});
            var h = a.find('.creative_select_option:first').height();
            var c = parseFloat(a.find('.creative_select_option:first').css('padding-top'));
            var d = parseFloat(a.find('.creative_select_option:first').css('padding-bottom'));
            var e = b * (h + 1 * c + 1 * d);
            a.find('.creative_scoll_inner_wrapper').css({'max-height': e});
            a.find('.creative_options_wrapper').css({'visibility': 'visible', 'display': 'none'})
        };setTimeout(function () {
            for (var a in T) {
                if (typeof (T[a]) !== "function") {
                    $("#sel_" + T[a]).trigger("click")
                }
            }
        }, 10);
        $("body").click(function (e) {
            if (!$(e.target).hasClass('creative_selected_option') && !$(e.target).hasClass('ccf_close_icon') && !$(e.target).hasClass('option_of_multiple_select') && !$(e.target).hasClass('wrapper_of_multiple_select') && !$(e.target).hasClass('ccf_select_icon') && !$(e.target).hasClass('creative_search') && !$(e.target).hasClass('creative_search_input') && !$(e.target).hasClass('do_not_hide_onclcik') && !$(e.target).hasClass('mCSB_buttonDown') && !$(e.target).hasClass('mCSB_buttonUp') && !$(e.target).hasClass('mCSB_dragger_bar') && !$(e.target).hasClass('mCSB_draggerContainer') && !$(e.target).hasClass('mCustomScrollBox') && !$(e.target).hasClass('mCSB_dragger') && !$(e.target).hasClass('mCSB_draggerRail') && !$(e.target).hasClass('creative_scrollbar')) {
                close_creative_options($('.creative_select'))
            }
        });
        var U = true;
        $('.creative_select .creative_input_dummy_wrapper,.creative_select .ccf_select_icon').on('click', function () {
            var a = $(this).parents('.creative_select');
            if (a.hasClass('opened')) {
                U = false;
                close_creative_options(a)
            } else {
                $('.creative_select.opened').removeClass('focused').removeClass('opened').find('.ccf_select_icon').removeClass('opened').addClass('closed').parents('.creative_select').find('.creative_options_wrapper').hide();
                open_creative_options(a);
                $('.creative_search_input').focus()
            }
        });
        $(window).scroll(function () {
            replace_creative_optios_wrapper($('.creative_select.opened'))
        });
        $(window).resize(function () {
            replace_creative_optios_wrapper($('.creative_select.opened'))
        });

        function replace_creative_optios_wrapper(a) {
            var b = a.offset();
            if (b == null) return;
            var c = parseFloat(b.top);
            var d = parseFloat($(window).scrollTop());
            var e = parseFloat($(window).height());
            var f = e - 33 - (c - d);
            if (a.find('.creative_options_wrapper').css('display') == 'none') {
                a.find('.creative_options_wrapper').css({'visibility': 'hidden', 'display': 'block'});
                var g = parseFloat(a.find('.creative_options_wrapper').height()) + 2 * 1;
                a.find('.creative_options_wrapper').css({'visibility': 'visible', 'display': 'none'})
            } else {
                var g = parseFloat(a.find('.creative_options_wrapper').height()) + 2 * 1
            }
            ;
            if (f > g + 10 * 1) {
                a.find('.creative_options_wrapper').css({'top': '100%', 'bottom': 'auto'})
            } else {
                a.find('.creative_options_wrapper').css({'bottom': '100%', 'top': 'auto'})
            }
        };

        function open_creative_options(a) {
            a.addClass('opened');
            a.removeClass('closed');
            a.addClass('focused');
            a.find('.ccf_select_icon').removeClass('closed').addClass('opened');
            replace_creative_optios_wrapper(a);
            a.find('.creative_options_wrapper').stop().fadeIn(400)
        };

        function close_creative_options(a) {
            if (U) a.addClass('closed');
            a.removeClass('opened');
            a.removeClass('focused');
            a.find('.ccf_select_icon').removeClass('opened').addClass('closed');
            setTimeout(function () {
                U = true;
                a.removeClass('closed')
            }, 500);
            a.find('.creative_options_wrapper').stop().fadeOut(400)
        };$(".single_select .creative_select_option").on('click', function () {
            if (!$(this).hasClass('selected')) {
                var a = $(this).parents('.creative_select').prev('select');
                a.find('option').removeAttr('selected');
                var b = $(this).attr("opt_id");
                $("#" + b).prop("selected", true);
                var c = $("#" + b).val();
                a.val(c);
                $(this).parent('div').find('.creative_select_option').removeClass('selected');
                $(this).addClass('selected');
                var d = $(this).find('.creative_opt_value').html();
                d = d.replace('<b>', '');
                d = d.replace('</b>', '');
                $(this).parents('.creative_select ').find('.creative_selected_option').html(d);
                $(this).parents('.creative_select ').find('.ccf_close_icon').show();
                validate_select($(this).parents('.creative_select'), false)
            } else {
                return
            }
        });
        $(".multiple_select .creative_select_option").on('click', function () {
            if (!$(this).hasClass('selected')) {
                var a = $(this).parents('.creative_select').prev('select');
                var b = $(this).attr("opt_id");
                $(this).addClass('selected');
                make_multiple_select_value($(this).parents('.creative_select'))
            } else {
                var a = $(this).parent('div').parent('div').prev('select');
                var b = $(this).attr("opt_id");
                $(this).removeClass('selected');
                var c = $(this).find('.creative_opt_value').html();
                $(this).parents('.creative_select').find('.creative_selected_option').html(c);
                make_multiple_select_value($(this).parents('.creative_select'))
            }
            validate_multiple_select($(this).parents('.creative_select'), false)
        });

        function make_multiple_select_value(c) {
            var d = 0;
            var e = c.find('.creative_select_option.selected').length;
            var f = '';
            c.prev('select').find('option').removeAttr('selected');
            c.find('.creative_select_option.selected').each(function () {
                var a = $(this).attr("opt_id");
                var b = $(this).find('.creative_opt_value').html();
                b = b.replace('<b>', '');
                b = b.replace('</b>', '');
                $("#" + a).prop("selected", true);
                f += b;
                if (d != e - 1) f += ', ';
                c.find('.creative_selected_option').html(f);
                d++
            });
            if (d == 0) {
                c.prev('select').find('option').removeAttr('selected');
                c.prev('select').find('.def_value').prop("selected", true);
                var g = c.prev('select').find('.def_value').html();
                c.find('.creative_selected_option').html(g)
            }
        };$('.ccf_close_icon').on('click', function () {
            U = false;
            $(this).parents('.creative_select').prev('select').find('option').removeAttr('selected');
            $(this).parents('.creative_select').prev('select').find('.def_value').attr('selected', 'selected');
            var a = $(this).parents('.creative_select').prev('select').find('.def_value').html();
            $(this).parents('.creative_select').find('.creative_selected_option').html(a);
            $(this).parents('.creative_select').find('.creative_select_option').removeClass('selected');
            $(this).hide();
            validate_select($(this).parents('.creative_select'), false)
        });
        $('.creative_search_input').on('keyup', function () {
            var a = $.trim($(this).val());
            if (a == '') {
                make_search($(this).parents('.creative_select'), a);
                return
            } else {
                make_search($(this).parents('.creative_select'), a)
            }
        });
        $('.creative_search_input').on('focus', function () {
            $(this).parent('div').addClass('focused')
        });
        $('.creative_search_input').on('blur', function () {
            $(this).parent('div').removeClass('focused')
        });

        function escapeRegExp(a) {
            return a.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&")
        };

        function make_search(j, k) {
            var c = 0;
            j.find('.creative_select_option').each(function () {
                var a = $(this).find('.creative_opt_value').html();
                a = a.replace('<b>', '');
                a = a.replace('</b>', '');
                var b = escapeRegExp(k);
                var d = new RegExp('^' + b + '| ' + b, 'gi');
                if (d.test(a)) {
                    var e = k.toLowerCase();
                    var f = a.toLowerCase();
                    var g = parseInt(f.indexOf(e));
                    var h = g + parseInt(e.length) + 3 * 1;
                    var i = a.substr(0, g) + '<b>' + a.substr(g);
                    i = i.substr(0, h) + '</b>' + i.substr(h);
                    $(this).find('.creative_opt_value ').html(i);
                    $(this).show();
                    c++
                } else {
                    $(this).removeClass('selected');
                    $(this).hide()
                }
            });
            if (c == 0) {
                j.find('.creative_select_empty_option').show().find('span').html(k)
            } else {
                j.find('.creative_select_empty_option').hide()
            }
            ;make_multiple_select_value(j)
        };

        function check_pro_version(a) {
            $elem_1 = a.find('.powered_by');
            $elem_2 = a.find('.powered_by a');
            var b = parseInt($elem_1.css('font-size'));
            var c = parseInt($elem_1.css('top'));
            var d = parseInt($elem_1.css('left'));
            var e = parseInt($elem_1.css('bottom'));
            var f = parseInt($elem_1.css('right'));
            var g = parseInt($elem_1.css('text-indent'));
            var h = parseInt($elem_1.css('margin-top'));
            var i = parseInt($elem_1.css('margin-bottom'));
            var j = parseInt($elem_1.css('margin-left'));
            var k = parseInt($elem_1.css('margin-right'));
            var l = $elem_1.css('display');
            var m = $elem_1.css('position');
            var n = parseInt($elem_1.css('width'));
            var o = parseInt($elem_1.css('height'));
            var p = $elem_1.css('visibility');
            var q = $elem_1.css('overflow');
            var r = parseInt($elem_1.css('z-index'));
            var s = parseInt($elem_2.css('font-size'));
            var t = parseInt($elem_2.css('top'));
            var u = parseInt($elem_2.css('left'));
            var v = parseInt($elem_2.css('bottom'));
            var w = parseInt($elem_2.css('right'));
            var x = parseInt($elem_2.css('text-indent'));
            var y = parseInt($elem_2.css('margin-top'));
            var z = parseInt($elem_2.css('margin-right'));
            var A = parseInt($elem_2.css('margin-bottom'));
            var B = parseInt($elem_2.css('margin-left'));
            var C = $elem_2.css('display');
            var D = $elem_2.css('position');
            var E = parseInt($elem_2.css('width'));
            var F = parseInt($elem_2.css('height'));
            var G = $elem_2.css('visibility');
            var H = $elem_2.css('overflow');
            var I = parseInt($elem_2.css('z-index'));
            var J = $.trim($elem_1.html().replace(/<[^>]+>.*?<\/[^>]+>/gi, ''));
            var K = $.trim($elem_2.html().replace(/<[^>]+>.*?<\/[^>]+>/gi, ''));
            var L = parseInt(J.length);
            var M = parseInt(K.length);
            var N = $elem_2.attr("href").replace('http://', '');
            N = N.replace('www.', '');
            N = $.trim(N.replace('www', ''));
            a_href_l = parseInt(N.length);
            if (b == '12' && c == '0' && d == '0' && e == '0' && f == '0' && g == '0' && h == '4' && k == '0' && i == '0' && j == '0' && l == 'block' && m == 'relative' && n > '20' && o > '10' && p == 'visible' && q == 'visible' && r == '10' && s == '14' && t == '0' && u == '0' && v == '0' && w == '0' && x == '0' && y == '0' && z == '0' && A == '0' && B == '0' && C != 'none' && D == 'relative' && E > '20' && F > '10' && G == 'visible' && H == 'visible' && I == '10' && J != '' && K == 'Creative Contact Form' && N == 'creative-solutions.net/joomla/creative-contact-form') return true;
            return false
        };

        function ccf_apply_copyright() {
            $('.creativecontactform_wrapper').each(function () {
                var a = '<div class="powered_by powered_by_1 ccf_bc_hidden">Powered By <a rel="nofollow" href="http://creative-solutions.net/joomla/creative-contact-form" target="_blank">Creative Contact Form</a></div>';
                $(this).find('.ccf_copyright_wrapper').html(a);
                setTimeout(function () {
                    $('.ccf_bc_hidden').removeClass('ccf_bc_hidden')
                }, 2000)
            })
        };ccf_apply_copyright();
        $('.reload_creative_captcha').click(function (e) {
            var a = $(this).attr('fid');
            var b = creativecontactform_juri + '/components/com_creativecontactform/captcha.php?fid=' + a + '&r=' + Math.random();
            var c = $(this).attr('holder');
            $(this).prev('img').attr('src', b);
            if (e.originalEvent !== undefined) {
                $(this).parents('.creativecontactform_field_box').find('input.creative_captcha:last').focus()
            }
        });
        $('.creative_fileupload_submit').mousedown(function () {
            var a = parseFloat($(this).parents('.creative_fileupload_wrapper').find('.creative_upload_info').attr("upload_maxfilesize")) * 1048576;
            var b = parseFloat($(this).parents('.creative_fileupload_wrapper').find('.creative_upload_info').attr("upload_minfilesize"));
            var c = $(this).parents('.creative_fileupload_wrapper').find('.creative_upload_info').attr("upload_acceptfiletypes");
            var d = '(\.|\/)(' + c + ')$';
            var e = new RegExp(d, 'i');
            var f = creativecontactform_juri + '/index.php?option=com_creativecontactform&view=creativeupload&format=raw';
            $(this).fileupload({minFileSize: b, maxFileSize: a, acceptFileTypes: e, url: f, dataType: 'json'})
        });
        $('.creative_fileupload_submit').on('fileuploaddone', function (e, f) {
            var g = $(this).parents('.creative_fileupload_wrapper').find('.creative_uploaded_files');
            $.each(f.result.files, function (a, b) {
                var c = 'MB';
                var d = b.size / 1048576;
                if (d < 1) {
                    d = d * 1024;
                    c = 'KB'
                }
                ;d = d.toFixed(1);
                var e = '<div class="creative_uploaded_file_item" ><input type="hidden" class="creative_active_upload" name="creativecontactform_upload[]" value="' + b.name + '" /><div class="creative_uploaded_icon"></div><div class="creative_uploaded_file">' + b.name + ' (' + d + c + ')</div><div class="creative_remove_uploaded"></div></div>';
                g.append(e)
            });
            var h = $(this).parents('.creative_fileupload_wrapper').find('.creative_progress');
            setTimeout(function () {
                h.animate({'height': 0}, 600);
                h.find('.bar').css({'width': 0});
                validate_file_upload(g.parents('.creative_file-upload'), false)
            }, 2000);
            $('.creative_remove_uploaded').on('click', function () {
                $(this).parent('.creative_uploaded_file_item').animate({'height': 0}, function () {
                    $(this).hide()
                });
                var a = 'creativecontactform_removed_upload[]';
                $(this).parent('.creative_uploaded_file_item').find('.creative_active_upload').addClass('creative_removed_upload').removeClass('creative_active_upload').attr("name", a);
                validate_file_upload($(this).parents('.creative_file-upload'), false)
            })
        }).on('fileuploadprocessalways', function (e, a) {
            var b = a.index, file = a.files[b], original_error_message = '';
            if (file.error) {
                if (file.error == 'error_message_file_types') original_error_message = $(this).parents('.creative_fileupload_wrapper').find('.creative_upload_info').attr("upload_acceptfiletypes_message"); else if (file.error == 'error_message_file_large') original_error_message = $(this).parents('.creative_fileupload_wrapper').find('.creative_upload_info').attr("upload_maxfilesize_message"); else if (file.error == 'error_message_file_small') original_error_message = $(this).parents('.creative_fileupload_wrapper').find('.creative_upload_info').attr("upload_minfilesize_message");
                var c = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_form_id').val();
                ccf_make_alert(original_error_message, 'creative_error', c)
            }
        }).on('fileuploadprogressall', function (e, a) {
            var b = $(this).parents('.creative_fileupload_wrapper').find('.creative_progress');
            var c = parseInt(a.loaded / a.total * 100, 10);
            b.find('.bar').css('width', c + '%')
        }).on('fileuploadstart', function (e, a) {
            var b = $(this).parents('.creative_fileupload_wrapper').find('.creative_progress');
            b.animate({'height': 15}, 600)
        }).on('fileuploadfail', function (e, a) {
            console.log(a);
            console.log(a.result);
            var b = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_form_id').val();
            ccf_make_alert('Error uploading file', 'creative_error', b)
        });
        $(".creative_datepicker").each(function () {
            var d = $(this);
            var e = d.parent('div');
            var f = e.attr("datepicker_date_format");
            var g = e.attr("datepicker_animation");
            var h = 'creative_datepicker_style_' + parseInt(e.attr("datepicker_style"));
            var i = e.attr("datepicker_icon_style");
            var j = e.attr("datepicker_show_icon");
            var k = e.attr("datepicker_input_readonly");
            var l = parseInt(e.attr("datepicker_number_months"));
            var m = e.attr("datepicker_mindate");
            var n = e.attr("datepicker_maxdate");
            var o = parseInt(e.attr("datepicker_changemonths")) == 0 ? false : true;
            var p = parseInt(e.attr("datepicker_changeyears")) == 0 ? false : true;
            var q = e.attr("juri");
            var r = q + '/components/com_creativecontactform/assets/images/datepicker/style-' + i + '.png';
            var s = j == 0 ? 'focus' : (k == 0 ? 'both' : 'both');
            var t = new RegExp("^[0-9]{4}:[0-9]{4}$", "i");
            var u = t.test(m);
            var v = u ? m : '';
            m = u ? '' : m;
            if (v == '') {
                d.datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: false,
                    changeMonth: o,
                    changeYear: p,
                    minDate: m,
                    maxDate: n,
                    showAnim: g,
                    dateFormat: f,
                    numberOfMonths: l,
                    showOn: s,
                    buttonImage: r,
                    buttonImageOnly: true,
                    buttonText: "Select date",
                    beforeShow: function (a, b) {
                        var c = $('#ui-datepicker-div').parent('.creative_datepicker_wrapper').length;
                        if (c == 0) $('#ui-datepicker-div').wrap('<div class="creative_datepicker_wrapper ' + h + '"></div>')
                    }
                })
            } else {
                d.datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: false,
                    changeMonth: o,
                    changeYear: p,
                    yearRange: v,
                    minDate: m,
                    maxDate: n,
                    showAnim: g,
                    dateFormat: f,
                    numberOfMonths: l,
                    showOn: s,
                    buttonImage: r,
                    buttonImageOnly: true,
                    buttonText: "Select date",
                    beforeShow: function (a, b) {
                        var c = $('#ui-datepicker-div').parent('.creative_datepicker_wrapper').length;
                        if (c == 0) $('#ui-datepicker-div').wrap('<div class="creative_datepicker_wrapper ' + h + '"></div>')
                    }
                })
            }
        });
        $('.creative_input_reset,.creative_textarea_reset').focus(function () {
            if (!$(this).hasClass('mouseentered')) $(this).trigger('mousedown')
        });
        $('.creative_input_reset,.creative_textarea_reset').mousedown(function () {
            $(this).addClass('mouseentered');
            var a = $(this).parent('div').find('.tooltip_inner');
            a.css('display', 'block');
            setTimeout(function () {
                a.removeClass('creative_tooltip_ivisible');
                a.addClass('cr_rotate')
            }, 100)
        });
        $('.creative_input_reset,.creative_textarea_reset').blur(function () {
            $(this).removeClass('mouseentered');
            var a = $(this).parent('div').find('.tooltip_inner');
            a.addClass('creative_tooltip_ivisible');
            a.removeClass('cr_rotate');
            setTimeout(function () {
                a.css('display', 'none')
            }, 500)
        });

        function create_zoom_in_animation(a) {
            a.filter('.creative_wrapper_animation_state_1').addClass('creative_wrapper_animation_state_2');
            a.find('.creative_header_animation_state_1').addClass('creative_header_animation_state_2');
            a.find('.creative_field_box_animation_state_1').addClass('creative_field_box_animation_state_2');
            a.find('.creative_footer_animation_state_1').addClass('creative_footer_animation_state_2');
            a.filter('.creative_wrapper_animation_state_1_short').addClass('creative_wrapper_animation_state_2_short');
            a.find('.creative_header_animation_state_1_short').addClass('creative_header_animation_state_2_short');
            a.find('.creative_field_box_animation_state_1_short').addClass('creative_field_box_animation_state_2_short');
            a.find('.creative_footer_animation_state_1_short').addClass('creative_footer_animation_state_2_short');
            setTimeout(function () {
                a.filter('.creative_wrapper_animation_state_1').removeClass('creative_wrapper_animation_state_1').removeClass('creative_wrapper_animation_state_2');
                a.find('.creative_header_animation_state_1').removeClass('creative_header_animation_state_1').removeClass('creative_header_animation_state_2');
                a.find('.creative_field_box_animation_state_1').removeClass('creative_field_box_animation_state_1').removeClass('creative_field_box_animation_state_2');
                a.find('.creative_footer_animation_state_1').removeClass('creative_footer_animation_state_1').removeClass('creative_footer_animation_state_2')
            }, 3000);
            setTimeout(function () {
                a.filter('.creative_wrapper_animation_state_1_short').removeClass('creative_wrapper_animation_state_1_short').removeClass('creative_wrapper_animation_state_2_short');
                a.find('.creative_header_animation_state_1_short').removeClass('creative_header_animation_state_1_short').removeClass('creative_header_animation_state_2_short');
                a.find('.creative_field_box_animation_state_1_short').removeClass('creative_field_box_animation_state_1_short').removeClass('creative_field_box_animation_state_2_short');
                a.find('.creative_footer_animation_state_1_short').removeClass('creative_footer_animation_state_1_short').removeClass('creative_footer_animation_state_2_short')
            }, 1500)
        }

        function set_zoom_in_animation(a) {
            a.filter('.creativecontactform_wrapper').addClass('creative_wrapper_animation_state_1_short');
            a.find('.creativecontactform_header').addClass('creative_header_animation_state_1_short');
            a.find('.creative_field_box_wrapper').addClass('creative_field_box_animation_state_1_short');
            a.find('.creativecontactform_footer').addClass('creative_footer_animation_state_1_short')
        }

        $('.creativecontactform_wrapper').each(function () {
            var b = $(this);
            var c = b.attr("render_type");
            var d = b.find('.v4_data');
            var e = d.attr("appear_animation_type");
            if (c == 0 && e == 1) {
                create_zoom_in_animation(b)
            }
            if (c == 0 && e == 2) {
                b.wrap('<div class="ccf_flip_wrapper"></div>');
                b.addClass('opacity_0').css({
                    '-moz-transform': 'rotateY(-10deg)',
                    '-webkit-transform': 'rotateY(-10deg)',
                    '-o-transform': 'rotateY(-10deg)',
                    'transform': 'rotateY(-10deg)',
                    'textIndent': '-10px'
                });
                setTimeout(function () {
                    b.addClass('opacity_transition');
                    b.removeClass('opacity_0');
                    b.animate({textIndent: 0}, {
                        step: function (a) {
                            $(this).css('-moz-transform', 'rotateY(' + a + 'deg)');
                            $(this).css('-webkit-transform', 'rotateY(' + a + 'deg)');
                            $(this).css('-o-transform', 'rotateY(' + a + 'deg)');
                            $(this).css('transform', 'rotateY(' + a + 'deg)')
                        }, duration: 1500, easing: 'easeOutElastic'
                    })
                }, 100);
                setTimeout(function () {
                    $('.ccf_cached_wrapper').removeClass('ccf_flip_wrapper');
                    b.removeClass('opacity_0').removeClass('opacity_transition')
                }, 1600)
            }
        });
        var V = (function () {
            var a, v = 3, div = document.createElement('div'), all = div.getElementsByTagName('i');
            while (div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->', all[0]) ;
            return v > 4 ? v : a
        }());
        if (V) {
            $('.creativecontactform_input_element,.creativecontactform_wrapper,.creativecontactform_send,.creativecontactform_send_new').css('border-radius', '0')
        }
        ;$('.creative_input_reset').on('focus', function () {
            if ($(this).parents('.creativecontactform_wrapper').attr('focus_anim_enabled') == 0) return;
            if ($(this).parents('.creativecontactform_field_box').hasClass('creativecontactform_error')) return;
            var a = $(this).parents('.creativecontactform_field_box').find('label');
            var b = a.attr("normal_effect_class");
            var c = a.attr("hover_effect_class");
            var d = a.attr("error_effect_class");
            a.removeClass(b).addClass(c)
        });
        $('.creative_textarea_reset').on('focus', function () {
            if ($(this).parents('.creativecontactform_wrapper').attr('focus_anim_enabled') == 0) return;
            if ($(this).parents('.creativecontactform_field_box').hasClass('creativecontactform_error')) return;
            var a = $(this).parents('.creativecontactform_field_box').find('label');
            var b = a.attr("normal_effect_class");
            var c = a.attr("hover_effect_class");
            var d = a.attr("error_effect_class");
            a.removeClass(b).addClass(c)
        });
        $('.creative_input_reset').on('blur', function () {
            if ($(this).parents('.creativecontactform_wrapper').attr('focus_anim_enabled') == 0) return;
            var a = $(this).parents('.creativecontactform_field_box').find('label');
            var b = a.attr("normal_effect_class");
            var c = a.attr("hover_effect_class");
            var d = a.attr("error_effect_class");
            a.removeClass(c).addClass(b)
        });
        $('.creative_textarea_reset').on('blur', function () {
            if ($(this).parents('.creativecontactform_wrapper').attr('focus_anim_enabled') == 0) return;
            var a = $(this).parents('.creativecontactform_field_box').find('label');
            var b = a.attr("normal_effect_class");
            var c = a.attr("hover_effect_class");
            var d = a.attr("error_effect_class");
            a.removeClass(c).addClass(b)
        });

        function create_validation_effects(e) {
            if (e.attr('error_anim_enabled') == 0) return;
            e.find('.creativecontactform_field_box').each(function () {
                var a = $(this).find('label').not('.twoglux_label');
                var b = a.attr("normal_effect_class");
                var c = a.attr("hover_effect_class");
                var d = a.attr("error_effect_class");
                if ($(this).hasClass('creativecontactform_error')) a.removeClass(c).removeClass(b).addClass(d); else a.removeClass(c).removeClass(d).addClass(b)
            })
        };$('.creativecontactform_send').hover(function () {
            var a = $(this).attr("normal_effect_class");
            var b = $(this).attr("hover_effect_class");
            $(this).removeClass(a).addClass(b)
        }, function () {
            var a = $(this).attr("normal_effect_class");
            var b = $(this).attr("hover_effect_class");
            $(this).removeClass(b).addClass(a)
        });
        $('.creative_fileupload').hover(function () {
            var a = $(this).attr("normal_effect_class");
            var b = $(this).attr("hover_effect_class");
            $(this).removeClass(a).addClass(b)
        }, function () {
            var a = $(this).attr("normal_effect_class");
            var b = $(this).attr("hover_effect_class");
            $(this).removeClass(b).addClass(a)
        });

        function ccf_create_shadow() {
            var a = '<div id="creative_shadow"></div>';
            $('body').css('position', 'relative').append(a);
            var b = parseInt($(window).width());
            var c = parseInt($(window).height());
            $("#creative_shadow").css({
                'position': 'fixed',
                'top': '0',
                'right': '0',
                'bottom': '0',
                'left': '0',
                'z-index': '10000',
                'opacity': '0',
                'width': b + 'px',
                'height': c + 'px',
                'backgroundColor': '#000'
            }).fadeTo(200, '0.7')
        };

        function ccf_resize_shadow() {
            if ($('#creative_shadow').length == 0) return;
            var a = parseInt($(window).width());
            var b = parseInt($(window).height());
            $("#creative_shadow").css({'width': a + 'px', 'height': b + 'px'})
        }

        function ccf_make_alert(a, b, c) {
            ccf_create_shadow();
            var d = close_alert_text[c];
            var e = '<div id="creative_alert_wrapper"><div id="creative_alert_body" class="' + b + '">' + a + '</div><input type="button" id="close_creative_alert" value="' + d + '" /></div>';
            $('body').append(e);
            var f = $(window).scrollTop();
            var g = $(window).width();
            var h = $(window).height();
            var i = $("#creative_alert_wrapper").height();
            var j = (g - 420) / 2;
            var k = (h - i) / 2;
            $("#creative_alert_wrapper").css({
                'top': -1 * (i + 55 * 1) + f * 1,
                'left': j
            }).stop().animate({'top': k + f * 1}, 450, 'easeOutBack', function () {
            })
        };

        function ccf_remove_alert_box() {
            if ($('#creative_alert_wrapper').length == 0) return;
            setTimeout(function () {
                var b = $('.ccf_popup_form').length;
                var c = false;
                $('.ccf_popup_form').each(function () {
                    var a = parseInt($(this).css('top'));
                    if (a != -100000) {
                        c = true;
                        return false
                    }
                });
                if ((!b || (b && !c))) $("#creative_shadow").stop().fadeTo(200, 0, function () {
                    $(this).remove()
                })
            }, 10);
            $("#creative_alert_wrapper").stop().fadeTo(200, 0, function () {
                $(this).remove()
            })
        };

        function ccf_move_alert_box() {
            if ($('#creative_alert_wrapper').length == 0) return;
            var a = $(window).scrollTop();
            var b = $(window).width();
            var c = $(window).height();
            var d = $("#creative_alert_wrapper").height();
            var e = (b - 420) / 2;
            var f = (c - d) / 2;
            $("#creative_alert_wrapper").stop().animate({'top': f + a * 1, 'left': e}, 450, 'easeOutBack', function () {
            })
        };$(document).on('click', '#close_creative_alert,#creative_shadow', function () {
            ccf_remove_alert_box()
        });
        $(window).resize(function () {
            ccf_resize_shadow();
            ccf_move_alert_box();
            ccf_move_popup_box()
        });
        $(window).scroll(function () {
            ccf_move_alert_box();
            ccf_move_popup_box()
        });
        $(".ccf_popup_link").click(function () {
            var a = $(this).parents('.creativecontactform_wrapper').find('.creativecontactform_send').attr("roll");
            var b = parseInt($(this).attr("popup_id"));
            var c = parseInt($(this).attr("w"));
            var d = parseInt($(this).attr("h"));
            ccf_make_popup(b, c, d, a)
        });

        function ccf_make_popup(a, b, c, d) {
            ccf_create_shadow();
            var e = $("#popup_" + a).html();
            var f = '<div id="creative_popup_wrapper" style="width: ' + b + 'px;height: ' + c + 'px;"><div class="ccf_close_popup"><div class="ccf_close_popup_icon"></div><div class="ccf_close_popup_bg"></div></div><div class="ccf_popup_inner_wrapper creative_form_' + d + '">' + e + '</div></div>';
            $('body').append(f);
            var g = $(".creativecontactform_wrapper.creative_form_" + d).attr("scrollbar_popup_style");
            $(".ccf_popup_inner_wrapper").mCustomScrollbar({
                mouseWheel: {enable: true},
                scrollButtons: {enable: true},
                theme: g
            });
            var h = $(window).scrollTop();
            var i = $(window).width();
            var j = $(window).height();
            var k = (i - b) / 2;
            var l = (j - c) / 2;
            k = k < 0 ? 0 : k;
            l = l < 0 ? 0 : l;
            if (k == 0 || l == 0) {
                $("#creative_popup_wrapper").addClass('disableScroll')
            }
            $("#creative_popup_wrapper").css({
                'top': -1 * (c + 55 * 1) + h * 1,
                'left': k
            }).stop().animate({'top': l + h * 1}, 450, 'easeOutBack', function () {
            })
        };

        function ccf_move_popup_box() {
            if ($('#creative_shadow').length == 0) return;
            var a = $(window).scrollTop();
            var b = $(window).width();
            var c = $(window).height();
            var d = $("#creative_popup_wrapper").width();
            var e = $("#creative_popup_wrapper").height();
            var f = (b - d) / 2;
            var g = (c - e) / 2;
            f = f < 0 ? 0 : f;
            g = g < 0 ? 0 : g;
            if (!$("#creative_popup_wrapper").hasClass('disableScroll')) {
                $("#creative_popup_wrapper").stop().animate({
                    'top': g + a * 1,
                    'left': f
                }, 450, 'easeOutBack', function () {
                })
            }
            if (f == 0 || g == 0) {
                $("#creative_popup_wrapper").addClass('disableScroll')
            } else $("#creative_popup_wrapper").removeClass('disableScroll')
        };

        function ccf_remove_popup_box() {
            if ($('#creative_shadow').length == 0) return;
            setTimeout(function () {
                var b = $('.ccf_popup_form').length;
                var c = false;
                $('.ccf_popup_form').each(function () {
                    var a = parseInt($(this).css('top'));
                    if (a != -100000) {
                        c = true;
                        return false
                    }
                });
                if ((!b || (b && !c))) $("#creative_shadow").stop().fadeTo(200, 0, function () {
                    $(this).remove()
                })
            }, 10);
            $("#creative_popup_wrapper").stop().fadeTo(200, 0, function () {
                $(this).remove()
            })
        };$(document).on('click', '.ccf_close_popup,#creative_shadow', function () {
            ccf_remove_popup_box()
        });
        $(".creativecontactform_wrapper").each(function () {
            var a = $(this);
            var b = parseInt(a.attr("render_type"));
            if (b == 0) {
                return
            } else if (b == 1 || b == 2 || b == 3 || b == 4) {
                var c = a;
                if (b == 3) {
                    var d = c.find('.v4_data');
                    var e = d.attr("popup_button_text");
                    var f = d.attr("static_button_position");
                    var g = d.attr("static_button_offset");
                    var h = d.attr("form_id");
                    var i = d.attr("form_w");
                    if (i.indexOf('%') !== -1) {
                        var j = 450;
                        c.attr("style", "width: " + j + "px !important")
                    }
                    var k = c.width() + 50 * 1;
                    var l = '<div class="ccf_static_button ccf_static_button_hidden_' + f + ' ccf_static_button_' + h + ' ccf_button_align_' + f + '" form_id="' + h + '" style="top: ' + g + ';">' + e + '</div>';
                    $("body").append(l);
                    setTimeout(function () {
                        $('.ccf_static_button').removeClass('ccf_static_button_hidden_0');
                        $('.ccf_static_button').removeClass('ccf_static_button_hidden_1')
                    }, 1500);
                    $('.ccf_static_button').attr("offset_index", k);
                    if (!$('.ccf_cached_wrapper').length) {
                        var m = '<div class="ccf_cached_wrapper"></div>';
                        $("body").append(m)
                    }
                    $('.ccf_cached_wrapper').append(c);
                    var n = f == 0 ? 'left' : 'right';
                    c.addClass('ccf_static_form');
                    c.css({'top': g,});
                    if (n == 'left') {
                        c.css({'left': -1 * k,})
                    } else {
                        c.css({'right': -1 * k,})
                    }
                    $('.ccf_static_button_' + h).on('click', function () {
                        if ($(this).hasClass('ccf_static_button_opened')) {
                            if (n == 'left') {
                                $('.creative_form_' + h).stop().animate({left: -1 * k}, 400, 'swing')
                            } else if (n == 'right') {
                                $('.creative_form_' + h).stop().animate({right: -1 * k}, 400, 'swing')
                            }
                            $(this).removeClass('ccf_static_button_opened')
                        } else {
                            if (n == 'left') {
                                $('.creative_form_' + h).stop().animate({left: 0}, 400, 'swing')
                            } else if (n == 'right') {
                                $('.creative_form_' + h).stop().animate({right: 0}, 400, 'swing')
                            }
                            $(this).addClass('ccf_static_button_opened')
                        }
                    })
                } else if (b == 1 || b == 2) {
                    var d = c.find('.v4_data');
                    var e = d.attr("popup_button_text");
                    var h = d.attr("form_id");
                    var i = d.attr("form_w");
                    if (i.indexOf('%') !== -1) {
                        var j = 500;
                        c.attr("style", "width: " + j + "px !important")
                    }
                    var k = c.width();
                    if (b == 1) var o = '<div class="ccf_popup_button ccf_popup_button_' + h + '" form_id="' + h + '" >' + e + '</div>'; else if (b == 2) var o = '<div class="ccf_popup_link ccf_popup_link_' + h + '" form_id="' + h + '" >' + e + '</div>';
                    c.after(o);
                    if (!$('.ccf_cached_wrapper').length) {
                        var m = '<div class="ccf_cached_wrapper"></div>';
                        $("body").append(m)
                    }
                    c.addClass('ccf_popup_form');
                    $('.ccf_cached_wrapper').append(c);
                    $(".ccf_popup_button.ccf_popup_button_" + h).on('click', function () {
                        ccf_show_popup_form(h)
                    });
                    $(".ccf_popup_link.ccf_popup_link_" + h).on('click', function () {
                        ccf_show_popup_form(h)
                    })
                } else if (b == 4) {
                    var d = c.find('.v4_data');
                    var e = d.attr("popup_button_text");
                    var f = d.attr("static_button_position");
                    var h = d.attr("form_id");
                    var i = d.attr("form_w");
                    if (i.indexOf('%') !== -1) {
                        var j = 250;
                        c.attr("style", "width: " + j + "px !important")
                    }
                    var k = c.width();
                    var p = '<div class="ccf_chat_button_wrapper ccf_chat_align_' + f + '"><div class="ccf_chat_button ccf_chat_btn_cursor_pointer ccf_chat_button_top_30 ccf_chat_button_' + h + ' " form_id="' + h + '" ><div class="ccf_chat_btn_txt">' + e + '</div><div class="ccf_chat_btn_sign"></div></div></div>';
                    $("body").append(p);
                    $('.ccf_chat_button').attr("btn_w", $('.ccf_chat_button').width() + 2 * 1);
                    $('.ccf_chat_button').addClass('ccf_chat_button_transition');
                    setTimeout(function () {
                        $('.ccf_chat_button').removeClass('ccf_chat_button_top_30')
                    }, 800);
                    setTimeout(function () {
                        $('.ccf_chat_button').removeClass('ccf_chat_button_transition')
                    }, 1300);
                    if (!$('.ccf_cached_wrapper').length) {
                        var m = '<div class="ccf_cached_wrapper"></div>';
                        $("body").append(m)
                    }
                    c.addClass('ccf_chat_form');
                    c.addClass('ccf_chat_align_' + f);
                    $('.ccf_cached_wrapper').append(c);
                    var q = parseInt(c.height()) + 2 * 1;
                    c.attr("form_h", q).css("bottom", -1 * q);
                    $(".ccf_chat_button.ccf_chat_button_" + h).on('click', function () {
                        ccf_show_chat_form(h)
                    })
                }
            }
        });

        function ccf_show_popup_form(b) {
            ccf_create_shadow();
            var c = $(".ccf_popup_form.creative_form_" + b);
            var d = c.find('.v4_data');
            var e = d.attr("appear_animation_type");
            if (e == 2) {
                $('.ccf_cached_wrapper').addClass('ccf_flip_wrapper');
                c.addClass('opacity_0').css({
                    '-moz-transform': 'rotateY(-10deg)',
                    '-webkit-transform': 'rotateY(-10deg)',
                    '-o-transform': 'rotateY(-10deg)',
                    'transform': 'rotateY(-10deg)',
                    'textIndent': '-10px'
                });
                setTimeout(function () {
                    c.addClass('opacity_transition');
                    c.removeClass('opacity_0');
                    c.animate({textIndent: 0}, {
                        step: function (a) {
                            $(this).css('-moz-transform', 'rotateY(' + a + 'deg)');
                            $(this).css('-webkit-transform', 'rotateY(' + a + 'deg)');
                            $(this).css('-o-transform', 'rotateY(' + a + 'deg)');
                            $(this).css('transform', 'rotateY(' + a + 'deg)')
                        }, duration: 1500, easing: 'easeOutElastic'
                    })
                }, 100);
                setTimeout(function () {
                    $('.ccf_cached_wrapper').removeClass('ccf_flip_wrapper');
                    c.removeClass('opacity_0').removeClass('opacity_transition')
                }, 1600)
            } else if (e == 1) {
                setTimeout(function () {
                    create_zoom_in_animation(c)
                }, 5)
            }
            c.addClass('no_transition');
            var f = parseInt(c.width());
            var g = parseInt(c.height());
            var h = parseInt($('#creative_shadow').width());
            var i = parseInt($(window).scrollTop());
            var j = parseInt($(window).height());
            var k = g < j ? ((j - g) / 2) * 0.8 : j * 0.05;
            var l = (h - f) / 2;
            var m = k + i * 1;
            c.css({top: m, left: l});
            setTimeout(function () {
                c.removeClass('no_transition')
            }, 1)
        }

        $(window).resize(function () {
            ccf_move_popup()
        });

        function ccf_move_popup() {
            var a = $('.ccf_popup_form').length;
            var b = parseInt($('.ccf_popup_form').css('top'));
            var c = b == -100000 ? false : true;
            if (a && c) {
                $form = $('.ccf_popup_form');
                $form.addClass('no_transition');
                var d = parseInt($form.width());
                var e = parseInt($form.height());
                var f = parseInt($('#creative_shadow').width());
                var g = parseInt($(window).scrollTop());
                var h = parseInt($(window).height());
                var i = e < h ? ((h - e) / 2) * 0.8 : h * 0.05;
                var j = (f - d) / 2;
                var k = i + g * 1;
                $form.css({top: k, left: j});
                setTimeout(function () {
                    $form.removeClass('no_transition')
                }, 1)
            } else {
                return
            }
        }

        function ccf_hide_popup_form() {
            var c = $('.ccf_popup_form');
            if (c.length) {
                c.each(function () {
                    $form = $(this);
                    $form.addClass('no_transition');
                    var a = $form.find('.v4_data');
                    var b = parseInt(a.attr("appear_animation_type"));
                    if (b == 1) {
                        set_zoom_in_animation($form)
                    }
                    $form.css({top: '-100000px', left: '-100000px'})
                })
            }
        }

        $(document).on('click', '#creative_shadow', function () {
            ccf_hide_popup_form()
        });

        function ccf_show_chat_form(a) {
            if ($('.ccf_chat_button_' + a).hasClass('ccf_chat_opened')) return;
            $('.ccf_chat_button_' + a).addClass('ccf_chat_opened');
            $('.ccf_chat_button_' + a).css('top', '30px').removeClass('ccf_chat_btn_cursor_pointer');
            var b = $(".ccf_chat_form.creative_form_" + a);
            var c = b.find('.v4_data');
            var d = b.attr('form_h');
            var e = b.width();
            b.animate({bottom: 0}, 400, 'swing');
            setTimeout(function () {
                $('.ccf_chat_button_' + a).find('.ccf_chat_btn_sign').addClass('ccf_chat_hide');
                $('.ccf_chat_button_wrapper').css('width', e);
                $('.ccf_chat_button_' + a).css({'top': -1 * d, 'width': e})
            }, 400)
        }

        function ccf_hide_chat(a) {
            var b = $(".ccf_chat_form.creative_form_" + a);
            var c = b.attr('form_h');
            b.css({'bottom': -1 * c});
            $('.ccf_chat_button_' + a).find('.ccf_chat_btn_sign').removeClass('ccf_chat_hide');
            $('.ccf_chat_button_' + a).addClass('ccf_chat_btn_cursor_pointer');
            var d = $('.ccf_chat_button_' + a).attr("btn_w");
            $('.ccf_chat_button_' + a).parents('.ccf_chat_button_wrapper').width(d);
            $('.ccf_chat_button_' + a).width(d);
            $('.ccf_chat_button_' + a).css('top', 0);
            $('.ccf_chat_button_' + a).addClass('ccf_chat_button_top_30');
            setTimeout(function () {
                $('.ccf_chat_button_' + a).addClass('ccf_chat_button_transition');
                $('.ccf_chat_button').removeClass('ccf_chat_button_top_30')
            }, 400);
            setTimeout(function () {
                $('.ccf_chat_button_' + a).removeClass('ccf_chat_button_transition')
            }, 900);
            $('.ccf_chat_button_' + a).removeClass('ccf_chat_opened')
        }

        $(document).on('click', '.ccf_chat_hide', function () {
            var a = $(this).parents('.ccf_chat_button').attr('form_id');
            ccf_hide_chat(a)
        })
    })
})(creativeJ);