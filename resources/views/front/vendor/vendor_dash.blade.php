@extends('front.layouts.layout') @section('content')

<div class="banner-tailors">
    <div class="container browse-tailors">
        <div class="row browse-content">
            <h1 class="text-white">Merchant-Dashboard</h1>
        </div>
    </div>
</div>

<div class="container-fluid page-body-wrapper vendor-dasboard">
    @include('front.vendor.vendor_sidebar')

    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="dash-text">Dashboard</h3>

            <div class="row card-vendor-inner">
                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-tale one">
                        <div class="card-body one">
                            <p class="text-one">Today's Users</p>
                            <p class="fs-30">4006</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body two">
                            <p class="text-one">Total Users</p>
                            <p class="fs-30 mb-2">8511</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body three">
                            <p class="text-one">Today's Plan Purchase</p>
                            <p class="fs-30 mb-2">1132</p>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="/resources/chart.js/chart.umd.js"></script>

<script src="/resources/js/off-canvas.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Task", "Hours per Day"],
            ["Work", 11],
            ["Eat", 2],
            ["Commute", 2],
            ["Watch TV", 2],
            ["Sleep", 7],
        ]);

        var options = {
            title: "My Daily Activities",
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById("piechart_3d"));
        chart.draw(data, options);
    }
</script>

<script>
    const ctx = document.getElementById("sales-chart").getContext("2d");

    const salesChart = new Chart(ctx, {
        type: "bar",

        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],

            datasets: [
                {
                    label: "Votes",

                    data: [12, 19, 3, 5, 2, 3, 20, 18, 11, 28, 8, 9],

                    backgroundColor: [
                        "rgba(255, 99, 132, 0.2)",

                        "rgba(54, 162, 235, 0.2)",

                        "rgba(255, 206, 86, 0.2)",

                        "rgba(75, 192, 192, 0.2)",

                        "rgba(153, 102, 255, 0.2)",

                        "rgba(255, 159, 64, 0.2)",

                        "rgba(255, 99, 132, 0.2)",

                        "rgba(54, 162, 235, 0.2)",

                        "rgba(255, 206, 86, 0.2)",

                        "rgba(75, 192, 192, 0.2)",

                        "rgba(153, 102, 255, 0.2)",

                        "rgba(255, 159, 64, 0.2)",
                    ],

                    borderColor: [
                        "rgba(255, 99, 132, 1)",

                        "rgba(54, 162, 235, 1)",

                        "rgba(255, 206, 86, 1)",

                        "rgba(75, 192, 192, 1)",

                        "rgba(153, 102, 255, 1)",

                        "rgba(255, 159, 64, 1)",

                        "rgba(255, 99, 132, 1)",

                        "rgba(54, 162, 235, 1)",

                        "rgba(255, 206, 86, 1)",

                        "rgba(75, 192, 192, 1)",

                        "rgba(153, 102, 255, 1)",

                        "rgba(255, 159, 64, 1)",
                    ],

                    borderWidth: 1,
                },
            ],
        },

        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("sales-chart").getContext("2d");

        new Chart(ctx, {
            /* Chart configuration */
        });
    });
</script>

@endsection
