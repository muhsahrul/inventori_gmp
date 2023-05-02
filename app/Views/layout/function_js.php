<script>
    $(function() {
        var path = window.location.pathname.split('/').slice(0, 3).join('/');
        console.log(path);
        $('ul li a').each(function() {
            if (this.pathname === path) {
                $(this).addClass('active');
                $(this).parents().addClass('menu-open');
                $(this).parents().children().addClass('active');
            }
        });
    });

    window.accessAlert = function() {
        $(function() {
            Swal.fire({
                icon: "error",
                title: "Akses Ditolak",
                text: "Anda tidak mempunyai akses ke halaman ini...!",
            });
        })
    }

    $('#cabang').change(function() {
        let cabang = document.getElementById('cabang').value;
        $.ajax({
            url: "<?= site_url(); ?>main/changeActiveCabang/" + cabang,
            dataType: "JSON",
            success: function(response) {
                if (response.error) {
                    errorAlert(response.message);
                } else {
                    successAlert(response.message);
                    window.location.reload();
                }
            }
        })
    })

    window.loadTable = function(id_filter = false, url = false) {
        let data_filter = $(id_filter).serialize();
        $.ajax({
            url: url,
            data: data_filter,
            success: function(data) {
                $('#table_view').html(data);
                datatableDefault();
            }
        })
    }

    window.successAlert = function(message) {
        Swal.fire({
            toast: true,
            icon: "success",
            title: message,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    }

    window.errorAlert = function(message) {
        Swal.fire({
            toast: true,
            icon: "error",
            title: message,
            position: 'top-end',
            showConfirmButton: false,
            timer: 9000,
            timerProgressBar: true,
        });
    }

    window.datepickerDefault = function() {
        $('.date-default').datetimepicker({
            format: 'L',
            format: 'DD-MM-YYYY',
        });
    }

    window.datepickerToday = function() {
        $('.date-today').datetimepicker({
            format: 'L',
            format: 'DD-MM-YYYY',
            defaultDate: Date.now(),
        });
    }

    window.datepickerTodayClear = function() {
        $('.date-today').datetimepicker({
            format: 'L',
            format: 'DD-MM-YYYY',
            defaultDate: Date.now(),
            buttons: {
                showClear: true,
            },
        });
    }

    window.datepickerDefaultClear = function() {
        $('.date-default').datetimepicker({
            format: 'L',
            format: 'DD-MM-YYYY',
            buttons: {
                showClear: true
            },
        });
    }

    window.datatableDefault = function() {
        $('#data-table').DataTable({
            paging: true,
            lengthChange: true,
            ordering: true,
            info: true,
            autoWidth: false,
            scrollX: true,
        });
    }

    window.select2Min = function() {
        $('.select2-min').select2({
            minimumResultsForSearch: Infinity,
        });
    }

    window.select2Clear = function() {
        $('.select2-min').select2({
            allowClear: true,
        });
    }

    window.select2Default = function() {
        $('.select2-default').select2({});
    }

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>