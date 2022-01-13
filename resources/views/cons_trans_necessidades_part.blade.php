@extends('master')

@section('content')


<div class="container-fluid">
    @if($status == 2)
        <h4 class="texto-oferta" style="color:rgb(197, 15, 233);">Transações em andamento para as Necessidades do Participante</h4> 
    @else
        @if($status == 3)
            <h4 class="texto-oferta" style="color:rgb(15, 135, 233);">Transações com confirmação parcial para as Necessidades do Participante</h4> 
        @else
            @if($status == 4)
                <h4 class="texto-oferta" style="color:rgb(101, 12, 218);">Transações Finalizadas para as Necessidades do Participante</h4> 
            @endif    
        @endif
    @endif
     
    
    <h4 class="texto-nome-logado">{{Session::get('nomelogado')}}</h4> 
    <br>

    <form class="row g-3" method="get" action="">

          @csrf
     
          <div class="col-sm-8">
               <input class="form-control texto_m" name="consulta_nec_part" value="" placeholder="Digite palavras para consulta..." type="search">
               <input name="id_part" type="hidden" value=""> 
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          
        </div>
        
    </form>

    <br>

    @if (isset($nec_status)) 

    <table  class="table table-sm">
        <thead style="border-bottom: 1px solid black;" class="texto_m">
          <tr>

             <th scope="col">Necessidades</th>
             <th scope="col">Ofertas</th>
             <th scope="col">Definições</th>
             <th scope="col">Ações</th>
            
          </tr>
        </thead>

        <tbody>
          @if (count($nec_status)>0)

              @foreach($nec_status as $nec_st)

                       <tr>
                        <td>
                          <div class="col">
                                  <div class="card" >
                                        <div class="card-body header-necessidade">
                                        <div class="row align-items-start">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col">
                                                        <h6 class="card-title texto-necessidade">Necessidade : {{$nec_st->desc_nec}}</h6>       
                                                    </div>
                                                    <div class="col texto_p">
                                                      @php
                                                          if($nec_st->data_final_nec_part <> null){
                                                            $date = new DateTime($nec_st->data_final_nec_part);
                                                            echo "Confirmada em : ".$date->format('d-m-Y'). " (UTC: ".$date->format('H:i').")" ;
                                                          }
                                                      @endphp

                                                    </div>

                                                  </div>
                                                </div>

                                                  <div class="card-text texto_p">Categoria : {{$nec_st->desc_cat_nec}}</div>
                                                  <div class="card-text texto_p">Participante : {{$nec_st->nome_part_nec}} </div>
                                                  <div class="card-text texto_p">Obs : {{$nec_st->obs_nec}}</div>   
                                                  
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                            </div>
                        </td>
                        
                        <td>
                          <div class="row">
                            <div class="col">
                                        <div class="card" >
                                              <div class="card-body header-oferta" >
                                                   <div class="row align-items-start">
                                                      <div class="col">
                                                          <div class="row">
                                                                <div class="col">
                                                                     <h6 class="card-title texto-oferta">Oferta : {{$nec_st->desc_of}}</h6>       
                                                                </div>
                                                                <div class="col texto_p">
                                                                  @php
                                                                      if($nec_st->data_final_of_part <> null){
                                                                        $date = new DateTime($nec_st->data_final_of_part);
                                                                        echo "Confirmada em : ".$date->format('d-m-Y'). " (UTC: ".$date->format('H:i').")" ;
                                                                      }
                                                                  @endphp

                                                                </div>
                                                              </div>
                                                          </div>

                                                           <div class="card-text texto_p">Categoria : {{$nec_st->desc_cat_of}} </div>
                                                           <div class="texto_p">
                                                           @php
                                                              if($nec_st->data_inic <> null){
                                                                $date = new DateTime($nec_st->data_inic);
                                                                echo "Início : ".$date->format('d-m-Y'). " (UTC: ".$date->format('H:i').")" ;
                                                              }
                                                           @endphp
                                                           </div>

                                                           <div class="card-text texto_p">Participante : {{$nec_st->nome_part_of}} </div>
                                                           <div class="card-text texto_p">Obs : {{$nec_st->obs_of}}</div>
                                                      </div>
                                                  </div>
                                              </div>
                                        </div>
                              </div>

                          </div>

                        </td>
                        
                        <td>
                          <div class="col">
                                  <div class="card" style="width: 20rem;" >

                                    <div class="card-body header-trans">
          
                                        <div class="row align-items-start">
                                            <div class="col">
                                                  <h6 class="card-title">Fluxo : {{$nec_st->fluxo}}</h6>
                                                  <div class="card-text texto_p">Qt Fluxo : {{$nec_st->quant_moeda}}</div>
                                                  <div class="card-text texto_p">Qt Oferta : {{$nec_st->quant_of}}</div>
                                                  @if($nec_st->fluxo == 'troca')
                                                      <div class="card-text texto_p">Qt Troca : {{$nec_st->quant_of_tr}}</div>
                                                  @else
                                                      <div class="card-text texto_p">Qt Necessidade : {{$nec_st->quant_nec}}</div>
                                                  @endif
                                                  
                                            </div>
                                            
                                        </div>
          
                                    </div>
                                  </div>
                            </div>
                        </td>
                        <td>
                          <form action="{{route('mens_transacoes_part')}}" method="get">
                        
                            @csrf 
                            <input value="{{Session::get('id_logado')}}" name="id_part_t" type="hidden">
                            <input value="{{$nec_st->id_nec_part}}" name="id_nec_part_t" type="hidden">
                            <input value="{{$nec_st->id_of_part}}" name="id_of_part_t" type="hidden"> 
                            <input value="0" name="id_of_tr_part_t" type="hidden"> 
                            <input value="nec" name="origem" type="hidden"> 
                            <button type="submit" class="btn btn-sm btn-mensagem bi-arrow-repeat texto_p">Detalhes da Transação</button>   
                           
                      </form>
                           
                       </td>
                       </tr>

              @endforeach

          @else
              <td><td>Nenhum registro encontrado</td></td>    
              
          @endif 

        </tbody>
      </table>

      <div class="pagination">
           {{$nec_status->links('layouts.paginationlinks')}}
           
      </div>

    @endif 

<div>

@endsection

