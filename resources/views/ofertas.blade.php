@extends('master')

@section('content')

<div class="container-fluid">

    <h2 class="texto-oferta">Ofertas</h2> 
    <br>
    
    <div class="row">
         <div class="col-10">
              <form class="d-flex" method="GET" action="{{route('consultar_ofertas')}}">
                @csrf
                <input class="form-control me-3 texto_m" name="consulta_of" value="{{Session::get('criterio_of')}}" type="search" placeholder="Digite palavras para consulta..." aria-label="Consultar">
                <button class="btn btn btn-primary me-3 texto_m" type="submit">Procurar</button>
              </form>
         </div>
         <div class="col">
              <form action="mostra_varios_parts" method="post">
                    @csrf

                    @if (isset($ofps_map)) 
                    <button class="btn btn-mapa btn-sm bi-globe texto_m" type="submit"> Mapa Geral</button>

                        <input value="0" name="nome_part" type="hidden">
                        <input value="Oferta" name="of_nec" type="hidden">
                        <input value="{{Session::get('latitude')}}" name="latitude" type="hidden">
                        <input value="{{Session::get('longitude')}}" name="longitude" type="hidden">

                        @if (count($ofps_map)>0)
                            @foreach($ofps_map as $ofp)  
                                <input value="{{$ofp->id_part}}" name="parts[{{ $loop->index }}][id]" type="hidden">
                                <input value="{{$ofp->latitude}}" name="parts[{{ $loop->index }}][latitude]" type="hidden">
                                <input value="{{$ofp->longitude}}" name="parts[{{ $loop->index }}][longitude]" type="hidden">
                                <input value="{{$ofp->nome_part}}" name="parts[{{ $loop->index }}][nome_part]" type="hidden">
                                <input value="{{$ofp->endereco}}" name="parts[{{ $loop->index }}][endereco]" type="hidden">
                            @endforeach
                        @endif

                    @endif


              </form>

        </div>

    </div>
    <br>
    @if (isset($ofps)) 

    <table class="table table-sm">
        <thead class="texto_m">
          <tr>
            <th scope="col">Descrição</th>
            <th scope="col">Data</th>
            <th scope="col">Quant</th>
            <th scope="col">Unidade</th>
            <th scope="col" colspan="2">Transações</th>
            <!-- <th scope="col" >Status Of</th>-->
            <th scope="col">Status</th>
            <th scope="col" >Local</th>
 
          </tr>
        </thead>
        <tbody>
          @if (count($ofps)>0)
              
              @foreach($ofps as $ofp)
                <div>
                  <td>
                    <div class="card" style="width: 45rem;">

                      <div class="card-body">

                           <div class="row align-items-start">
                               <div class="col">
                                    <h5 style="font-size:15px;"   class="card-title texto-oferta">Oferta : {{$ofp->desc_of}}</h5>
                                    <h6 style="color:rgb(4, 97, 97)"  class="card-subtitle mb-2 texto_m">Categoria : {{$ofp->desc_cat}} </h6>
                                    <p class="card-text texto_m">Obs : {{$ofp->obs}}</p>
                               </div>
                               <div class="col">
                                    <h6 class="texto_m">Nome : {{$ofp->nome_part}} </h6>
                                    <p class="texto_m">Endereço : {{$ofp->endereco}} , {{$ofp->cidade}} {{$ofp->estado}} - {{$ofp->pais}}</p>
                               </div>
                        
                            </div>

                      </div>
                    </div>
                  </td>

                  <td class="texto_m">
                    @php
                        $date = new DateTime($ofp->data);
                        echo $date->format('d-m-Y');
                     @endphp
                  </td>
                  <td class="texto_m">{{$ofp->quant}}</td>
                  <td class="texto_m">{{$ofp->desc_unid}}</td>
                    
                    <td>
                      <div class="row">
                          
                            <div class="col">
                                  @if($ofp->id_part <> Session::get('id_logado'))
                                    <form action="{{route('trans_trocas_part')}}" method="get">
                                      @csrf 
                                      <input value="{{$ofp->id_part}}" name="id_part_t" type="hidden">
                                      <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
                                      <input value="0" name="filtra_id_logado" type="hidden">
                                      <input value="{{Session::get('id_logado')}}" name="id_logado" type="hidden">

                                      <p><button type="submit" class="btn btn-sm btn-trocar bi-arrow-repeat texto_p">&nbspTrocar</button></p>   
                                    </form>
                                  @else
                                    <form action="{{route('trans_ofertas_part')}}" method="get">
                                      @csrf 
                                      <button type="submit" class="btn btn-sm btn-sugestoes bi-arrow-down-up texto_p">
                                        Sugestões <span class="badge sugestao-of-nec">
                                                  {{App\Http\Controllers\OfertasController::verifica_sugestoes_of(Session::get('id_logado'),$ofp->desc_cat,$ofp->desc_of,$ofp->obs,1)}}
                                                  </span>
                                      </button>
                                      <input value="1" name="filtra_id_logado" type="hidden">
                                      <input value="{{$ofp->id_part}}" name="id_part_t" type="hidden">
                                      <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
                                      
                                    </form>
                                  @endif  
                            </div>
                         
                      </div>  
                    </td>    
                    <td></td>

                  <!--  @if($ofp->status == 2)
                        <td class="texto_p texto-em-andamento"><h4 class="bi bi-chat-left-dots-fill"></h4></td>
                    @else
                        @if(($ofp->status == 3))
                            <td class="texto_p texto-parc-finalizada"><h4 class="bi bi-check-circle-fill"></h4></td>
                        @else 
                            @if($ofp->status == 4)
                                <td class="texto_p texto-finalizada"><h4 class="bi bi-check-circle-fill"></h4></td>
                            @else  
                                <td class="texto_p"></td>
                            @endif
                        @endif  
                    @endif    -->

                    <td>
                      <div class="row">
                        <div class="col-1 texto-em-andamento">
                          <span>
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_of_anda($ofp->id_of_part)
                          @endphp  
                        </span>
                        </div>

                        <div class="col-2 texto-em-andamento">
                          <h6 class="bi bi-chat-left-dots-fill"></h6>
                        </div>

                        <div class="col-1 texto-parc-finalizada">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_of_parc($ofp->id_of_part)
                          @endphp  
                        </span>
                        </div>

                        <div class="col-2 texto-parc-finalizada">
                          <h6 class="bi bi-check-circle-fill"></h6>
                        </div>

                        <div class="col-1 texto-finalizada">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_of_final($ofp->id_of_part)
                          @endphp  
                        </span>
                        </div>

                        <div class="col-1 texto-finalizada">
                          <h6 class="bi bi-check-circle-fill"></h6>
                        </div>

                      </div>
                    </td>

                    <td>
                          <div style="" class="col">
                          @if($ofp->latitude<>null)
                            <form  action="/mostramapa/{{$ofp->id_part}}" method="post">
                                  @csrf
                                  <button type="submit" class="btn btn-mapa btn-sm bi-globe texto_p">
                                    Mapa
                                    </button>
                              </form>
                          @else
                              <form action="/mostramapa/{{$ofp->id_part}}" method="post">
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
           {{$ofps->links('layouts.paginationlinks')}}
           
      </div>

    @endif 
 
</div>

@endsection

