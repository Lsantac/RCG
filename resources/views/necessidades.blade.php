@extends('master')

@section('content')

<div class="container-fluid">

    <h2 class="texto-necessidade">Necessidades</h2> 
    <br>
    
    <div class="row">
         <div class="col-10">
              <form class="d-flex" method="GET" action="{{route('consultar_necessidades')}}">
                @csrf
                <input class="form-control me-3 texto_m" name="consulta_nec" value="{{Session::get('criterio_nec')}}" type="search" placeholder="Digite palavras para consulta..." aria-label="Consultar">
                <button class="btn btn btn-primary me-3 texto_m" type="submit">Procurar</button>
              </form>
         </div>
         <div class="col">
              <form action="mostra_varios_parts" method="post">
                    @csrf

                    @if (isset($necps_map)) 
                    <button class="btn btn-mapa btn-sm bi-globe texto_m" type="submit"> Mapa Geral</button>

                        <input value="0" name="nome_part" type="hidden">
                        <input value="Necessidade" name="of_nec" type="hidden">
                        <input value="{{Session::get('latitude')}}" name="latitude" type="hidden">
                        <input value="{{Session::get('longitude')}}" name="longitude" type="hidden">

                        @if (count($necps_map)>0)
                            @foreach($necps_map as $necp)  
                                <input value="{{$necp->id_part}}" name="parts[{{ $loop->index }}][id]" type="hidden">
                                <input value="{{$necp->latitude}}" name="parts[{{ $loop->index }}][latitude]" type="hidden">
                                <input value="{{$necp->longitude}}" name="parts[{{ $loop->index }}][longitude]" type="hidden">
                                <input value="{{$necp->nome_part}}" name="parts[{{ $loop->index }}][nome_part]" type="hidden">
                                <input value="{{$necp->endereco}}" name="parts[{{ $loop->index }}][endereco]" type="hidden">
                            @endforeach
                        @endif

                    @endif


              </form>

        </div>

    </div>
    <br>
    @if (isset($necps)) 

    <table class="table table-sm">
        <thead class="texto_m">
          <tr>
            <th scope="col">Descrição</th>
            <th scope="col">Data</th>
            <th scope="col">Quant</th>
            <th scope="col">Unidade</th>
            <th scope="col" class="pcenter" colspan="2">Transações</th>
            <th scope="col" >Status</th>
            <th scope="col" >Local</th>
 
          </tr>
        </thead>
        <tbody>
          @if (count($necps)>0)
              
              @foreach($necps as $necp)
                <div>
                  <td>
                    <div class="card" style="width: 45rem;">

                      <div class="card-body">

                           <div class="row align-items-start">
                               <div class="col">
                                    <h5 style="font-size:15px;"   class="card-title texto-necessidade">Necessidade : {{$necp->desc_nec}}</h5>
                                    <h6 style="color:rgb(97, 75, 4)"  class="card-subtitle mb-2 texto_m">Categoria : {{$necp->desc_cat}} </h6>
                                    <p class="card-text texto_m">Obs : {{$necp->obs}}</p>
                               </div>
                               <div class="col">
                                    <h6 class="texto_m">Nome : {{$necp->nome_part}} </h6>
                                    <p class="texto_m">Endereço : {{$necp->endereco}} , {{$necp->cidade}} {{$necp->estado}} - {{$necp->pais}}</p>
                               </div>
                        
                            </div>

                      </div>
                    </div>
                  </td>

                  <td class="texto_m">
                    @php
                        $date = new DateTime($necp->data);
                        echo $date->format('d-m-Y');
                     @endphp
                  </td>
                  <td class="texto_m">{{$necp->quant}}</td>
                  <td class="texto_m">{{$necp->desc_unid}}</td>
                    
                    <td>
                      <div class="row">
                            <div class="col pcenter no-margin">
                                <form action="{{route('trans_necessidades_part')}}" method="get">
                                  @csrf 

                                  @if($necp->id_part <> Session::get('id_logado'))
                                      <button type="submit" class="btn btn-sm btn-sugestoes-of bi-arrow-down-up texto_p">
                                        Sugestões <span class="badge sugestao-of-nec">
                                                  {{App\Http\Controllers\NecessidadesController::verifica_sugestoes_nec(Session::get('id_logado'),$necp->desc_cat,$necp->desc_nec,$necp->obs,0)}}
                                                  </span>
                                      </button>

                                      <input value="0" name="filtra_id_logado" type="hidden">
                                  @else
                                      <button type="submit" class="btn btn-sm btn-sugestoes bi-arrow-down-up texto_p">
                                        Sugestões <span class="badge sugestao-of-nec">
                                                  {{App\Http\Controllers\NecessidadesController::verifica_sugestoes_nec(Session::get('id_logado'),$necp->desc_cat,$necp->desc_nec,$necp->obs,1)}}
                                                  </span>
                                      </button>

                                      <input value="1" name="filtra_id_logado" type="hidden">
                                  @endif

                                  <input value="{{$necp->id_part}}" name="id_part_t" type="hidden">
                                  <input value="{{$necp->id_nec_part}}" name="id_nec_part_t" type="hidden">
                                  <input value="{{Session::get('id_logado')}}" name="id_logado" type="hidden">

                                </form>
                            </div>
                         
                      </div>  
                    </td>    
                    <td></td>
                     
                    @if($necp->status == 1)
                    <td class="texto_p texto-pendente"><h4 class="bi bi-chat-left-dots-fill"></h4></td>
                    @else
                        @if(($necp->status == 3) or ($necp->status == 2))
                            <td class="texto_p texto-em-andamento"><h4 class="bi bi-chat-left-dots-fill"></h4></td>
                        @else
                            @if($necp->status == 4)
                               <td class="texto_p texto-finalizada"><h4 class="bi bi-check-circle-fill"></h4></td>
                            @else  
                               <td class="texto_p"></td>
                            @endif 
                        @endif    
                    @endif

                    <td>
                          <div style="" class="col">
                          @if($necp->latitude<>null)
                            <form  action="/mostramapa/{{$necp->id_part}}" method="post">
                                  @csrf
                                  <button type="submit" class="btn btn-mapa btn-sm bi-globe texto_p">
                                    Mapa
                                    </button>
                              </form>
                          @else
                              <form action="/mostramapa/{{$necp->id_part}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-mapa-disable btn-sm bi-globe texto_p">
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

