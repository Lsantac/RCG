@extends('master')

@section('content')

<div class="container-fluid">

    <h2>Necessidades</h2> 
    <br>
    
    <div class='results'>
        @if(Session::get('fail_mapa'))
            <div class="alert alert-danger texto_m">
                {{Session::get('fail_mapa')}}
            </div>
        @endif
    </div>  

    <form class="d-flex" method="GET" action="{{route('consultar_necessidades')}}">

        @csrf

        <input class="form-control me-2 texto_m" name="consulta_nec" value="{{Session::get('criterio_nec')}}" type="search" placeholder="Digite palavras para consulta..." aria-label="Consultar">
        
        <button class="btn btn btn-primary me-2 texto_p" type="submit">Procurar</button>
            
    </form>

    <br>
    @if (isset($necps)) 

    <table class="table table-sm">
        <thead>
          <tr>
            <th scope="col" class="texto_p">Necessidade</th>
            <th scope="col" class="texto_p">Participante</th>
            
            <th scope="col" class="texto_p">Categoria</th>
            <th scope="col" class="texto_p">Data</th>
            <th scope="col" class="texto_p">Quant</th>
            <th scope="col" class="texto_p">Unidade</th>
            <th scope="col" class="texto_p">Observações</th>
            
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @if (count($necps)>0)
              
              @foreach($necps as $necp)
                <div>
                  <tr>
                    <td class="texto_p">{{$necp->desc_nec}}</td>
                    <td class="texto_p">{{$necp->nome_part}}</td>
                    <td class="texto_p">{{$necp->desc_cat}}</td>

                    <td class="texto_p">
                      @php
                          $date = new DateTime($necp->data);
                          echo $date->format('d-m-Y');
                       @endphp
                    </td>

                    <td class="texto_p">{{$necp->quant}}</td>
                    <td class="texto_p">{{$necp->desc_unid}}</td>
                    <td class="texto_p">{{$necp->obs}}</td>
                    
                    <td>
                      <div class="row">
                        <form class="col" action="" method="post">
                          @csrf 
                          <button type="submit" class="btn btn-sm btn-conectar bi-arrow-repeat texto_p"> Conectar</button>   
                          
                        </form> 

                       @if($necp->latitude<>null)
                         <form class="col" action="/mostramapa/{{$necp->id_part}}" method="post">
                               @csrf
                               <button type="submit" class="btn btn-mapa btn-sm bi-globe">
                                 Mapa
                                </button>
                          </form>
                       @else
                          <form class="col " action="/mostramapa/{{$necp->id_part}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-mapa-disable btn-sm bi-globe">
                              Mapa
                            </button>
                          </form>
                       @endif
                      </div>
                    </td>
                    
                  </tr>
                </div> 
                
              @endforeach

          @else
              <tr>
                <td>Nenhum registro encontrado</td>    
                <td></td>  
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              
          @endif 

        </tbody>
      </table>

      <div class="pagination">
           {{$necps->links('layouts.paginationlinks')}}
           
      </div>

    @endif 
 
</div>

@endsection

