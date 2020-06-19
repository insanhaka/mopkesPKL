var InitiateSimpleValidate = function () {
    return {
        init: function () {
            $.validator.addMethod('filesize', function (value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
            }, 'Ukuran File harus dibawah melebihi Batas');
            //Datatable Initiating
            var validate = $("form.validate").validate({
                errorElement: "em", // contain the error msg in a span tag
                errorClass: 'invalid-feedback',
                rules: {
                },
                messages: {
                },
                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("type") == "radio" || element.attr("type") == "checkbox" ||  element.attr("type") == "file") { // for chosen elements, need to insert the error after the chosen container
                        error.insertAfter($(element).closest('.form-group').children('div').last());
                    } else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
                        error.insertAfter($(element).closest('.form-group').children('div'));
                    } else if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent('.input-group'));
                    }
                    else if (element.siblings('.select2').length) {
                        error.insertAfter(element.parent().children('span.select2'));
                    }else if (element.siblings('.select2-min3').length) {
                        error.insertAfter(element.parent().children('span.select2-min3'));
                    } else {
                        error.insertAfter(element);
                    }
                    element.closest('.form-group').children('div').addClass("has-feedback");
                    if (!element.next("i")[0]) {
                        // $("<i class='fa fa-times form-control-feedback'></i>").insertAfter(element);
                    }
                },
                // success: function (label, element) {
                //     if (element.siblings("em").hasClass("help-block")) {
                //         element.siblings("em.help-block").hide();
                //     }
                // },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            return validate;
        }
    };
}();