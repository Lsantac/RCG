
@extends('master')

@section('content')

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        

        <div style="width:40%;" class="container">
             <canvas id="myChart" ></canvas>    
        </div>
        
        <script>
        const ctx = document.getElementById('myChart');

        const data = {
                labels: [
                    'Em andamento',
                    'Confirmada Parcialmente',
                    'Finalizada'
                ],
                datasets: [{
                    label: 'Estatistico das Transações',
                    /*data: [300, 50, 100],*/
                    data: <?php echo $data; ?>,
                    backgroundColor: [
                    'rgb(197, 15, 233)',
                    'rgb(15, 135, 233)',
                    'rgb(101, 12, 218)'
                    ],
                    hoverOffset: 4
                }]
                };

        


        const myChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            
        });
        </script>
        

@endsection
