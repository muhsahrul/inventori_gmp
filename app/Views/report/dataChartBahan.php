<div id="canvas">
    <canvas id="barChart" width="400" height="200"></canvas>
</div>
<script>
    $(function() {
        var filter_tahun = "<?= $filter_tahun; ?>";
        var filter_bahan = "<?= $filter_bahan ?>";
        $.ajax({
            url: "chartBahan/loadDataChartBahan",
            data: {
                tahun: filter_tahun,
                bahan: filter_bahan,
            },
            dataType: 'json',
            success: function(data) {
                var label = new Array();
                var datamasuk = new Array();
                var datakeluar = new Array();
                $.each(data, function(key, value) {
                    label.push(value.nama_bulan);
                    datamasuk.push(value.total_masuk * value.gramasi);
                    datakeluar.push(value.total_keluar);
                });
                $('#barChart').remove();
                $('#canvas').append('<canvas id="barChart"><canvas>');
                barChart(label, datamasuk, datakeluar);
            }
        });

    })

    function barChart(label, datamasuk, datakeluar) {

        const ctx = document.getElementById('barChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: label,
                datasets: [{
                        label: 'Total Masuk',
                        data: datamasuk,
                        borderColor: 'rgba(255, 99, 132, 0.5)',
                        backgroundColor: 'rgba(255, 99, 132, 1)',
                    },
                    {
                        label: 'Total Keluar',
                        data: datakeluar,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'month'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>