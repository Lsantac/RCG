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

    <h4 class="" style="color:rgb(91, 19, 207);">Sugestões de Transações para a oferta do Participante</h4> 
    <h5 class="texto-nome-logado">{{$nome_part_cab}}</h5> 
   

     @if (isset($ofps)) 

    <table class="table table-sm tabela-oferta">
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
              @foreach($ofps as $ofp)
                <div>
                  <tr>
                    <td>
                      <div class="col-1" >
                                <figure class="figure">
                    
                                  @if(!@empty($ofp->imagem))
                                      <img id="imagem_of_cons"  src="/uploads/of_img/{{$ofp->imagem}}" class="imagem-pequena">
                                  @else
                                      <img id="imagem_of_cons" src="/img/logo.jpg" class="imagem-pequena">
                                  @endif 
                          
                              </figure>
                        </div>
                    </td>

                    <td class="texto_p">{{$ofp->desc_of}}</td>
                    <td class="texto_p">{{$ofp->desc_cat}}</td>

                    <td class="texto_p">
                      @php
                          $date = new DateTime($ofp->data);
                          echo $date->format('d-m-Y');
                       @endphp
                    </td>

                    <td class="texto_p">{{$ofp->quant}}</td>
                    <td class="texto_p">{{$ofp->desc_unid}}</td>
                    <td class="texto_p">{{$ofp->obs}}</td>
                    
                  </tr>
                </div> 
                
              @endforeach

        </tbody>
      </table>

    @endif 

    <h4 class="texto-necessidade">Necessidades de outros Participantes</h4> 
    <br>

    <div style="float: left; width: 70%; "> 
        <form class="row g-3" method="get" action="{{route('consultar_trans_nec_part')}}">

          @csrf

          <input name="id_part_t" type="hidden" value="{{$part->id}}"> 
          <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
          <input value="1" name="filtra_id_logado" type="hidden">
          <input value="{{Session::get('id_logado')}}" name="id_logado" type="hidden">

          <div class="col-sm-10 g-3">
              <input class="form-control texto_p" name="criterio_nec" value="{{Session::get('criterio_nec')}}" placeholder="Digite palavras para procurar outras necessidades..." type="search">
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
      <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
      
    </form>
  </div> -->

  <div style="float: left; width: auto;" >
    <form style="display:inline;" action="{{route('trans_ofertas_part')}}" method="get">
      @csrf 
      
      <button type="submit" class="btn btn-sm btn-sugestoes texto_p ">Mostrar Sugestões</button>   
      <input value="{{$part->id}}" name="id_part_t" type="hidden">
      <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
      <input value="1" name="filtra_id_logado" type="hidden">

      
    </form>
  </div>

    @if (count($necps)>0)
        <div style="float:left; margin-left:20px;">
        <form style="display:inline;" action="mostra_varios_parts" method="post">
          @csrf 
          
          <button type="submit" class="btn btn-sm btn-mapa bi-globe texto_p"> Mapa</button> 

          <input value="{{$part->nome_part}}" name="nome_part" type="hidden">
          <input value="Oferta" name="of_nec" type="hidden">
          <input value="{{$part->latitude}}" name="latitude" type="hidden">
          <input value="{{$part->longitude}}" name="longitude" type="hidden">
          
          @foreach($necps as $necp)  
          <input value="{{$necp->id_part}}" name="parts[{{ $loop->index }}][id]" type="hidden">
          <input value="{{$necp->latitude}}" name="parts[{{ $loop->index }}][latitude]" type="hidden">
          <input value="{{$necp->longitude}}" name="parts[{{ $loop->index }}][longitude]" type="hidden">
          <input value="{{$necp->nome_part}}" name="parts[{{ $loop->index }}][nome_part]" type="hidden">
          <input value="{{$necp->endereco}}" name="parts[{{ $loop->index }}][endereco]" type="hidden">
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
  
     @if (isset($necps)) 

    <table class="table table-sm tabela-necessidade">
        <thead>
          <tr>
            <th scope="col" class="texto_p" >Imagem</th>
            <th scope="col" class="texto_p" >Descrição</th>
            <th scope="col" class="texto_p">Data</th>
            <th scope="col" class="texto_p">Quant</th>
            <th scope="col" class="texto_p">Unidade</th>
            <th scope="col" class="texto_p">Status</th>
            
            <!--<th scope="col" class="texto_p">Observações</th>-->
            <!--<th scope="col" class="texto_p">Distância/Kms</th>-->
            <th class="texto_p " colspan="2">Ações</th>
          </tr>
        </thead>

        <tbody>
          @if (count($necps)>0)

              @foreach($necps as $necp)
                <div>
                  <tr>
                      <td>
                        <div class="col-1" >
                                  <figure class="figure">

                                    <div class="d-block d-lg-none d-md-none d-xl-none d-xxl-none">
                                      @if(!@empty($necp->imagem))
                                         <img id="imagem_nec_cons"  src="/uploads/nec_img/{{$necp->imagem}}" class="imagem-of-nec-cons-p">
                                      @else
                                        <img id="imagem_nec_cons" src="/img/logo.jpg" class="imagem-of-nec-cons-p">
                                      @endif 
                                    </div>
                                    <div class="d-none d-sm-none d-md-block d-lg-block d-xl-block d-xxl-block">
                                        @if(!@empty($necp->imagem))
                                           <img id="imagem_nec_cons"  src="/uploads/nec_img/{{$necp->imagem}}" class="imagem-of-nec-cons">
                                        @else
                                          <img id="imagem_nec_cons" src="/img/logo.jpg" class="imagem-of-nec-cons">
                                        @endif 
                                    </div>
                             
                                </figure>
                          </div>
                      </td>
                    
                      <td>
                      <div  style="width: auto;">
                        <div >
                          <h5 class="card-title ">{{$necp->desc_nec}}</h5>
                          <h6 style="color:rgb(196, 104, 0)" class="card-subtitle mb-2 texto_p">Categoria : {{$necp->desc_cat}} </h6>
                          <p class="card-text texto_p">Obs : {{$necp->obs}}</p>
                          <p style="color:rgb(148, 48, 2)" class="card-subtitle mb-1 texto_p">Participante : {{$necp->nome_part}}</p>
                          <p style="color:rgb(148, 48, 2)" class="card-subtitle mb-1 texto_p">Endereço : {{$necp->endereco}} , {{$necp->cidade}} </p>
                          
                        </div>
                      </div>
                      </td>

                    <td class="texto_p">
                      @php
                          $date = new DateTime($necp->data);
                          echo $date->format('d-m-Y');
                      @endphp
                    </td>
                    
                    <td class="texto_p">{{$necp->quant}}</td>
                    <td class="texto_p">{{$necp->desc_unid}}</td>

                    <td>
                      <div class="row">
                        <div class="col-1 texto-em-andamento">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_nec_anda($necp->id_nec_part)
                          @endphp  
                        </span>
                        </div>

                        <div class="col-2 texto-em-andamento d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block">
                          <h6 class="bi bi-chat-left-dots-fill"></h6>
                        </div>

                        <div class="col-1 texto-parc-finalizada">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_nec_parc($necp->id_nec_part)
                          @endphp  
                        </span>
                        </div>

                        <div class="col-2 texto-parc-finalizada d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block">
                          <h6 class="bi bi-check-circle-fill"></h6>
                        </div>

                        <div class="col-1 texto-finalizada">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_nec_final($necp->id_nec_part)
                          @endphp  
                        </span>
                        </div>

                        <div class="col-1 texto-finalizada d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block">
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
                            <input value="of" name="origem" type="hidden"> 
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
      {{$necps->links('layouts.paginationlinks')}}
      
    </div>
<div>

@endsection


