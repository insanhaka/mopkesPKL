var InitiateSimpleDataTable = function () {
    return {
        init: function () {
            var table = $('#simpledatatable,.simpledatatable').dataTable({
                initComplete: function () {
                    this.api().columns(['.cbfilter']).every(function () {
                        var column = this;
                        var select = $('<select class="form-control form-control-sm select2" style="width: 100%"><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });
                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option class="form-control form-control-sm" value="' + d + '">' + d + '</option>')
                        });
                    });
                },
                "bAutoWidth": false,
                "language": {
                    "search": "",
                    "sLengthMenu": "_MENU_",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": 'no-sort' // <-- gets last column and turns off sorting
                }]
            });

            $('#simpledatatable thead th input[type=checkbox]').change(function () {
                var set = $("#simpledatatable tbody tr input[type=checkbox]");
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
            $('#simpledatatable tbody tr input[type=checkbox]').change(function () {
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
