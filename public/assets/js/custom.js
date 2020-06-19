/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
(function ($, window, i) {
    /**
     * Loader
     */
    $(document).ajaxStart(function () {
        $('.loading-container').show();
    }).ajaxStop(function () {
        $('.loading-container').fadeOut();
    });

    /**
     * [openModal description]
     * @param  {[type]} evt [description]
     * @return {[type]}     [description]
     */
    var openModal = function (evt) {
        // Create jQuery body object
        var $body = $('body'),
            $checkparamid = $(this).attr("paramsid"),
            $checkparamval = $(this).attr("paramsval");
        var parameter = ($checkparamid) ? '/' + $($checkparamid).val() : '';
        parameter += ($checkparamval) ? '/' + $checkparamval : '';

        var $trigger = $(this), // Trigger jQuery object
            url = ($trigger.attr('url')) ? $trigger.attr('url') : $trigger.attr('href'),
            modalPath = url + parameter, // Modal path is href of trigger
            $newModal, // Declare modal variable

            removeModal = function (evt) { // Remove modal handler
                $newModal.off('hidden.bs.modal'); // Turn off 'hide' event
                $newModal.remove(); // Remove modal from DOM
            },

            showModal = function (data) { // Ajax complete event handler
                $body.append(data); // Add to DOM
                $newModal = $('.modal').last(); // Modal jQuery object
                $newModal.modal('show'); // Showtime!
                $newModal.on('hidden.bs.modal', removeModal); // Remove modal from DOM on hide
            };

        $.get({
            url: modalPath,
            cache: false
        }).then(showModal);

        evt.preventDefault(); // Prevent default a tag behavior
    };
    $(document).on("click", '.modalTrigger', openModal);

    $.comboAjax = function (from, to, url) {
        var me = $(from);
        var target = $(to);
        me.on('change', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            target.empty();
            $.post(url, {
                "paramid": me.val()
            }, function (result) {
                $.each(result.data, function (index, val) {
                    target.append('<option value="' + val + '">' + index + '</option>');
                });
            });
        });
    }
})(jQuery, this, 0);
