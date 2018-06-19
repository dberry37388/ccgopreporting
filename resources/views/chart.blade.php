@extends('layouts.app')

@push('scripts')
    <script>
        $(function () {
            var myChart = Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Voter Turnout Comparison'
                },
                xAxis: {
                    categories: ['5/18', '8/16', '3/16', '8/14', '5/14', '8/12', '11/10', '5/10', '8/08']
                },
                yAxis: {
                    title: {
                        text: 'Total Voters'
                    }
                },
                series: [{
                    name: 'Republican',
                    color: '#AA0000',
                    data: {{ json_encode($republicanTotals) }}
                }, {
                    name: 'Democrat',
                    color: '#071765',
                    data: {{ json_encode($democratTotals) }}
                }]
            });
        });
    </script>

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">
                            Available Reports
                        </h4>
                    </div>

                    <div class="card-body">
                        <div id="container" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
