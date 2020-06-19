var InitiateSimpleDataTable = function () {
    return {
        init: function (url,columns,selector='#simpledatatable') {
            var table = $(selector).DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: columns
            });

            $(''+selector+' thead th input[type=checkbox]').change(function () {
                var set = $(""+selector+" tbody tr input[type=checkbox]");
                var checked = $(this).is(":checked");
                $(set).each(function () {
                    if (checked) {
                        $(this).prop("checked", true);
                        $(this).parents('tr').addClass("active");
                    } else {
                        $(this).prop("checked", false);
                        $(this).parents('tr').removeClass("active");
                    }
                });

            });
            $(''+selector+' tbody tr input[type=checkbox]').change(function () {
                $(this).parents('tr').toggleClass("active");
            });

            $(document).on('change', '.checkme,.checkall', function () {
                if ($(this).is(':checked')) {
                    $('#deleteall').fadeIn(300);
                } else {
                    if (!$('#form-delete').find('input[type=checkbox]').is(':checked')) {
                        $('#deleteall').fadeOut(300);
                    }
                }
            });
            return table;
        }
    };

}();
