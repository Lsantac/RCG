@extends('master')

@section('content')

<div class="container-fluid">

    <h4 class="texto-oferta" style="color:rgb(91, 19, 207);">Possiveis trocas para a oferta do Participante : 
      <span class="texto-nome-logado">{{$part->nome_part}}</span>
    </h4> 
     
    <br>

     @if (isset($ofps)) 

    <table class="table table-sm tabela-oferta texto_p">
        <thead>
          <tr>
            <th scope="col" >Oferta</th>
            <th scope="col" >Categoria</th>
            <th scope="col" >Data</th>
            <th scope="col" >Quant</th>
            <th scope="col" >Unidade</th>
            <th scope="col" >Observações</th>
            
          </tr>
        </thead>

        <tbody>
              @foreach($ofps as $ofp)
                <div>
                  <tr>
                    <td>{{$ofp->desc_of}}</td>
                    <td>{{$ofp->desc_cat}}</td>

                    <td>
                      @php
                          $date = new DateTime($ofp->data);
                          echo $date->format('d-m-Y');
                       @endphp
                    </td>

                    <td>{{$ofp->quant}}</td>
                    <td>{{$ofp->desc_unid}}</td>
                    <td>{{$ofp->obs}}</td>
                    
                  </tr>
                </div> 
                
              @endforeach

        </tbody>
      </table>

    @endif 

    <br>
    
    <h4 class="texto-oferta">Ofertas de : <span class="texto-nome-logado">{{Session::get('nomelogado')}}</span></h4>
     
    <br>

    <div style="float: left; width: 70%; "> 
        <form class="row g-3" method="get" action="{{route('consultar_trans_trocas_part')}}">

          @csrf
          <input name="id_part_t" type="hidden" value="{{$part->id}}"> 
          <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">        
          <input value="0" name="filtra_id_logado" type="hidden">
          <input value="{{Session::get('id_logado')}}" name="id_logado" type="hidden">
    
          <div class="col-sm-10 g-3">
              <input class="form-control texto_m" name="consultar_trans_troca_part" value="" placeholder="Digite palavras para procurar outras ofertas para trocar..." type="search">
          </div>
      
          <div style="text-align:center;width: 5%;"  class="col-sm-2">
            <button style="margin-right: 5px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
            <!--<a class="btn btn btn-redes bi-snow" type="button"> Incluir Rede</a> -->
          
          </div>
        
        </form>
      </div>

  <div style="float: left; width: auto;">
    <form style="display:inline;" action="" method="get">
      @csrf 
      
      <button type="submit" class="btn btn-sm btn-mostrar-mensagens texto_p">Mostrar Mensagens</button>   
      <input value="{{$part->id}}" name="id_part_t" type="hidden">
      <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
      
    </form>
  </div>

    @if (count($of_tr_ps)>0)
        <div style="float:left; margin-left:20px;"  >
        <form style="display:inline;" action="mostra_varios_parts" method="post">
          @csrf 
          
          <button type="submit" class="btn btn-sm btn-mapa bi-globe texto_p"> Mapa</button> 

          <input value="{{$part->nome_part}}" name="nome_part" type="hidden">
          <input value="Oferta" name="of_nec" type="hidden">
          <input value="{{$part->latitude}}" name="latitude" type="hidden">
          <input value="{{$part->longitude}}" name="longitude" type="hidden">
          
          @foreach($of_tr_ps as $of_tr_p)  
          <input value="{{$of_tr_p->id_part}}" name="parts[{{ $loop->index }}][id]" type="hidden">
          <input value="{{$of_tr_p->latitude}}" name="parts[{{ $loop->index }}][latitude]" type="hidden">
          <input value="{{$of_tr_p->longitude}}" name="parts[{{ $loop->index }}][longitude]" type="hidden">
          <input value="{{$of_tr_p->nome_part}}" name="parts[{{ $loop->index }}][nome_part]" type="hidden">
          <input value="{{$of_tr_p->endereco}}" name="parts[{{ $loop->index }}][endereco]" type="hidden">
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
  
     @if (isset($of_tr_ps)) 

    <table class="table table-sm tabela-oferta">
        <thead>
          <tr>
            <th scope="col" class="texto_p">Descrição</th>
            <!--<th scope="col" class="texto_p">Necessidade</th>
            <th scope="col" class="texto_p">Categoria</th>-->
            <th scope="col" class="texto_p">Data</th>
            <th scope="col" class="texto_p">Quant</th>
            <th scope="col" class="texto_p">Unidade</th>
            
            <!--<th scope="col" class="texto_p">Observações</th>-->
            <!--<th scope="col" class="texto_p">Distância/Kms</th>-->
            <th class="texto_p " colspan="3">Ações</th>
          </tr>
        </thead>

        <tbody>
          @if (count($of_tr_ps)>0)

              @foreach($of_tr_ps as $of_tr_p)
                <div>
                  <tr>
                      <td>
                      <div class="card" style="width: 58rem;">
                        <div class="card-body">
                          <h5 class="card-title">Oferta : {{$of_tr_p->desc_of}}</h5>
                          <h6 style="color:rgb(6, 155, 30)" class="card-subtitle mb-2 texto_p">Categoria : {{$of_tr_p->desc_cat}} </h6>
                          <p class="card-text texto_p">Obs : {{$of_tr_p->obs}}</p>
                          <p style="color:rgb(4, 82, 155)" class="card-subtitle mb-1 texto_p">Participante : {{$of_tr_p->nome_part}}</p>
                          <p style="color:rgb(4, 82, 155)" class="card-subtitle mb-1 texto_p">Endereço : {{$of_tr_p->endereco}} , {{$of_tr_p->cidade}} </p>
                          
                        </div>
                      </div>
                      </td>

                    <td class="texto_p">
                      @php
                          $date = new DateTime($of_tr_p->data);
                          echo $date->format('d-m-Y');
                       @endphp
                    </td>
                    
                    <td class="texto_p">{{$of_tr_p->quant}}</td>
                    <td class="texto_p">{{$of_tr_p->desc_unid}}</td>
                    
                    <td>
                      <form action="{{route('mens_transacoes_part')}}" method="get">
                        
                            @csrf 
                            <input value="{{$part->id}}" name="id_part_t" type="hidden">
                            <input value="{{$of_tr_p->id_of_part}}" name="id_of_tr_part_t" type="hidden">
                            <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden"> 
                        
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
      {{$of_tr_ps->links('layouts.paginationlinks')}}
      
    </div>
<div>

@endsection


