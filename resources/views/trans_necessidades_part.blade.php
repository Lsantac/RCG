@extends('master')

@section('content')

<div class="container-fluid">

    <div class='results'>
        @if(Session::get('fail_mapa'))
            <div class="alert alert-danger texto_p">
                {{Session::get('fail_mapa')}}
            </div>
        @endif
    </div>

    <h4 class="texto-necessidade">Sugestões de Transações para a Necessidade do Participante</h4> 
    <h5 class="texto-nome-logado">{{$part->nome_part}}</h5> 
    
     @if (isset($necps)) 

    <table class="table table-sm tabela-necessidade">
        <thead>
          <tr>
            <th scope="col" class="texto_p">Imagem</th>
            <th scope="col" class="texto_p">Descrição</th>
            <th scope="col" class="texto_p">Categoria</th>
            <th scope="col" class="texto_p">Data</th>
            <th scope="col" class="texto_p">Quant</th>
            <th scope="col" class="texto_p">Unidade</th>
            <th scope="col" class="texto_p">Observações</th>
            
          </tr>
        </thead>

        <tbody>
              @foreach($necps as $necp)
                <div>
                  <tr>
                    <td>
                      <div class="col-1" >
                                <figure class="figure">
                    
                                  @if(!@empty($necp->imagem))
                                      <img id="imagem_nec_cons"  src="/uploads/nec_img/{{$necp->imagem}}" class="imagem-pequena">
                                  @else
                                      <img id="imagem_nec_cons" src="/img/logo.jpg" class="imagem-pequena">
                                  @endif 
                          
                              </figure>
                        </div>
                    </td>
                    
                    <td class="texto_p">{{$necp->desc_nec}}</td>
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
                    
                  </tr>
                </div> 
                
              @endforeach

        </tbody>
      </table>

    @endif 

    <h4 class="texto-oferta">Ofertas de outros Participantes</h4> 
    <br>

    <div style="float: left; width: 70%; "> 
        <form class="row g-3" method="get" action="{{route('consultar_trans_of_part')}}">

          @csrf
          <input name="id_part_t" type="hidden" value="{{$part->id}}"> 
          <input value="{{$necp->id_nec_part}}" name="id_nec_part_t" type="hidden">

          @if($part->id == Session::get('id_logado'))
             <input value="1" name="filtra_id_logado" type="hidden">
          @else
             <input value="0" name="filtra_id_logado" type="hidden">
          @endif

          <input value="{{Session::get('id_logado')}}" name="id_logado" type="hidden">
    
          <div class="col-sm-10 g-3">
              <input class="form-control texto_p" name="criterio_of" value="{{Session::get('criterio_of')}}" placeholder="Digite palavras para procurar outras ofertas..." type="search">
          </div>
      
          <div style="text-align:center;width: 5%;"  class="col-sm-2">
            <button style="margin-right: 5px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
            <!--<a class="btn btn btn-redes bi-snow" type="button"> Incluir Rede</a> -->
          
          </div>
        
        </form>
      </div>

     <!-- <div style="float: left; width: auto;">
        <form style="display:inline;" action="" method="get">
          @csrf 
          
          <button type="submit" class="btn btn-sm btn-mostrar-mensagens texto_p">Mostrar Mensagens</button>   
          <input value="{{$part->id}}" name="id_part_t" type="hidden">
          <input value="{{$necp->id_nec_part}}" name="id_nec_part_t" type="hidden">
          
        </form>
      </div> -->

  <div style="float: left; width: auto;">
    <form style="display:inline;" action="{{route('trans_necessidades_part')}}" method="get">
      @csrf 
      
      <button type="submit" class="btn btn-sm btn-sugestoes texto_p">Mostrar Sugestões</button>   
      <input value="{{$part->id}}" name="id_part_t" type="hidden">
      <input value="{{$necp->id_nec_part}}" name="id_nec_part_t" type="hidden">
      <input value="1" name="filtra_id_logado" type="hidden">
      <input value="{{Session::get('id_logado')}}" name="id_logado" type="hidden">
      
    </form>
  </div>


    @if (count($ofps)>0)
        <div style="float:left; margin-left:20px;"  >
        <form style="display:inline;" action="mostra_varios_parts" method="post">
          @csrf 
          
          <button type="submit" class="btn btn-sm btn-mapa bi-globe texto_p"> Mapa</button> 

          <input value="{{$part->nome_part}}" name="nome_part" type="hidden">
          <input value="Necessidade" name="of_nec" type="hidden">
          <input value="{{$part->latitude}}" name="latitude" type="hidden">
          <input value="{{$part->longitude}}" name="longitude" type="hidden">
          
          @foreach($ofps as $ofp)  
          <input value="{{$ofp->id_part}}" name="parts[{{ $loop->index }}][id]" type="hidden">
          <input value="{{$ofp->latitude}}" name="parts[{{ $loop->index }}][latitude]" type="hidden">
          <input value="{{$ofp->longitude}}" name="parts[{{ $loop->index }}][longitude]" type="hidden">
          <input value="{{$ofp->nome_part}}" name="parts[{{ $loop->index }}][nome_part]" type="hidden">
          <input value="{{$ofp->endereco}}" name="parts[{{ $loop->index }}][endereco]" type="hidden">
          @endforeach
          
        </form>
        </div>  
   @else
   <div style="float:left; margin-left:20px;"  >
    
      <button type="submit" class="btn btn-sm btn-mapa-disable bi-globe texto_p"> Mapa</button> 
    
    </div>  
   @endif

  <br>
  <br>
  
     @if (isset($ofps)) 

    <table class="table table-sm tabela-oferta">
        <thead>
          <tr>
            <th scope="col" class="texto_p" >Imagem</th>
            <th scope="col" class="texto_p" >Descrição</th>
            <th scope="col" class="texto_p">Data</th>
            <th scope="col" class="texto_p">Quant</th>
            <th scope="col" class="texto_p">Unidade</th>
            <th scope="col" class="texto_p">Status</th>
            <th class="texto_p " colspan="3">Ações</th>
          </tr>
        </thead>

        <tbody>
          @if (count($ofps)>0)

              @foreach($ofps as $ofp)
                <div>
                  <tr>
                    <td>
                      <div class="col-1" >
                                <figure class="figure">
                    
                                  @if(!@empty($ofp->imagem))
                                      <img id="imagem_of_cons"  src="/uploads/of_img/{{$ofp->imagem}}" class="imagem-of-nec-cons">
                                  @else
                                      <img id="imagem_of_cons" src="/img/logo.jpg" class="imagem-of-nec-cons">
                                  @endif 
                          
                              </figure>
                        </div>
                    </td>
                    <td>
                      <div style="width: 58rem;">
                        <div>
                          <h5 class="card-title ">{{$ofp->desc_of}}</h5>
                          <h6 style="color:rgb(6, 155, 30)" class="card-subtitle mb-2 texto_p">Categoria : {{$ofp->desc_cat}} </h6>
                          <p class="card-text texto_p">Obs : {{$ofp->obs}}</p>
                          <p style="color:rgb(4, 82, 155)" class="card-subtitle mb-1 texto_p">Participante : {{$ofp->nome_part}}</p>
                          <p style="color:rgb(4, 82, 155)" class="card-subtitle mb-1 texto_p">Endereço : {{$ofp->endereco}} , {{$ofp->cidade}} </p>
                          
                        </div>
                      </div>
                    </td>


                    <!--<td class="texto_p">{{$ofp->nome_part}}</td>
                    <td class="texto_p">{{$ofp->desc_of}}</td>
                    <td class="texto_p">{{$ofp->desc_cat}}</td>-->
                    <td class="texto_p">
                      @php
                          $date = new DateTime($ofp->data);
                          echo $date->format('d-m-Y');
                       @endphp
                    </td>

                    <td class="texto_p">{{$ofp->quant}}</td>
                    <td class="texto_p">{{$ofp->desc_unid}}</td>
                    
                  
                    
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
                      <form action="{{route('mens_transacoes_part')}}" method="get">
                        
                        @csrf 
                        <input value="{{$part->id}}" name="id_part_t" type="hidden">
                        <input value="{{$necp->id_nec_part}}" name="id_nec_part_t" type="hidden">
                        <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden"> 
                        <input value="nec" name="origem" type="hidden"> 

                        <button type="submit" class="btn btn-sm btn-mensagem bi-arrow-repeat texto_p"> Detalhes da Transação</button>   
                       
                  </form>
                    </td>
                  </tr>
                </div> 
                
              @endforeach

          @else
              <td>Nenhum registro encontrado</td>    
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>    
          @endif 

        </tbody>
      </table>

    @endif 

    <div class="pagination">
      {{$ofps->links('layouts.paginationlinks')}}
      
    </div>
<div>

@endsection


