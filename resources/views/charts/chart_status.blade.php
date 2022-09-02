
@extends('master')

@section('content')

        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

        <html>
            <head>
                <title>Title</title>
                
            </head>
            <body>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title font-size-lg">Estatístico das Transações</div>
                                <canvas id="Categories"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
        
            </div>
            </body>
            </html>
            <script>
                var data = [{
                    data: <?php echo $data; ?>
                    backgroundColor: [
                    'rgb(197, 15, 233)',
                    'rgb(15, 135, 233)',
                    'rgb(101, 12, 218)'
                        
                    ],
                    borderColor: "#fff"
                }];
        
                var options = {
                    tooltips: {
                        enabled: false
                    },
                    plugins: {
                        
                        datalabels: {
                            
                            formatter: (value, categories) => {
        
                                let sum = 0;
                                let dataArr = categories.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = (value*100 / sum).toFixed(0)+"%";

                                const display = ['Transações: '+value,percentage]
                                return display;
        
                            },
                            
                            color: '#fff',

                        }
                    }
                };
        
        
                var categories = document.getElementById('Categories').getContext('2d');
                var myChart = new Chart(categories, {
                    type: 'pie',
                    data: {
                        labels: [
                    'Em andamento',
                    'Confirmada Parcialmente',
                    'Finalizada'
                    ],
                        datasets: data
                    },
                    options: options
                });
        
        
            </script>
        

@endsection
