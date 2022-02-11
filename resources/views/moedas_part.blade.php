@extends('master')

@section('content')

<div class="container">

    <h3 class="texto-moeda">Saldos das Moedas do Participante</h3> 
    <h5 class="texto-participante">{{Session('nomelogado')}}</h5> 
    <br>

    @if (isset($saldos)) 

    <table class="table table-sm texto_m">
        <thead>
          <tr>
            <th scope="col">Moeda</th>
            <th scope="col">Saldo</th>
          </tr>
        </thead>
        <tbody>
          @if (count($saldos)>0)
              @foreach($saldos as $sd)
                <div>
                  <tr>
                    <td>{{$sd->desc_moeda}}</td>
                    <td>
                      @php
                         echo number_format($sd->tot_moeda,2,",",".");
                      @endphp
                      
                    </td>
                  </tr>
                </div> 
              @endforeach

          @else
              <td><td>Nenhum registro encontrado</td></td>    
          @endif 

        </tbody>
      </table>

      <div class="pagination">
           {{$saldos->links('layouts.paginationlinks')}}
           
      </div>

    @endif 
  </div>

@endsection


