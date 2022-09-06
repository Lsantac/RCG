
@extends('master')

@section('content')

        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

        <html>
            
            <body>
                
            <div class="container">
                <div class="row">
                    @if($nome_rede<>"")
                       <h2 style="color:indianred">Estatístico das Transações - Rede: <span style="color:darkorchid">{{$nome_rede}}</span>   </h2>
                    @else
                       <h2 style="color:indianred">Estatístico das Transações</h2>
                    @endif
                    
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="btn-group">
                                     <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Consulta por Rede
                                     </button>
                                      <ul class="dropdown-menu">
                                        @foreach ($redes as $rede)
                                                 <li><a class="dropdown-item texto_m" href="/chart_rede/{{$rede->id_rede}}/{{Session('id_logado')}}">{{$rede->nome}}</a></li>
                                        @endforeach 
                                        
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item texto_m" href="/chart_part/{{Session('id_logado')}}">Todas do Participante</a></li>
                                      </ul>
                                </div>
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
                                let percentage = (value*100 / sum).toFixed(0    )+"%";

                                const display = ['Qt: '+value,percentage]
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
