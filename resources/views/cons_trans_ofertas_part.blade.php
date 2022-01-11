@extends('master')

@section('content')


<div class="container-fluid">
     
    <h4 class="texto-oferta">Transaçoes em andamento para as Ofertas do Participante</h4> 
    <h4 class="texto-nome-logado">{{Session::get('nomelogado')}}</h4> 
    <br>

    <form class="row g-3" method="get" action="">

          @csrf
     
          <div class="col-sm-8">
               <input class="form-control texto_m" name="consulta_of_part" value="" placeholder="Digite palavras para consulta..." type="search">
               <input name="id_part" type="hidden" value=""> 
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          
        </div>
        
    </form>

    <br>

    @if (isset($of_status)) 

    <table  class="table table-sm">
        <thead style="border-bottom: 1px solid black;" class="texto_m">
          <tr>

             <th scope="col">Ofertas</th>
             <th scope="col">Necessidades/Trocas</th>
             <th scope="col">Definições</th>
             <th scope="col">Ações</th>
            
          </tr>
        </thead>

        <tbody>
          @if (count($of_status)>0)

              @foreach($of_status as $of_st)

                       <tr>
                        
                        <td>
                          <div class="row">
                            <div class="col">
                                        <div class="card" >
                                              <div class="card-body header-oferta" >
                                                   <div class="row align-items-start">
                                                      <div class="col">
                                                           <h6 class="card-title texto-oferta">Oferta : {{$of_st->desc_of}}</h6>
                                                           <div class="card-text texto_p">Categoria : {{$of_st->desc_cat_of}} </div>
                                                           <div class="card-text texto_p">Participante : {{$of_st->nome_part_of}} </div>
                                                           <div class="card-text texto_p">Obs : {{$of_st->obs_of}}</div>
                                                      </div>
                                                  </div>
                                              </div>
                                        </div>
                              </div>

                          </div>

                        </td>
                        <td>
                          <div class="col">
                                  <div class="card" >
                                    @if($of_st->fluxo == 'troca')
                                        <div class="card-body header-troca">
                                    @else
                                        <div class="card-body header-necessidade">
                                    @endif   
          
                                        <div class="row align-items-start">
                                            <div class="col">
                                                  @if($of_st->fluxo == 'troca')
                                                     <h6 class="card-title texto-necessidade">Troca : {{$of_st->desc_of_tr}}</h6>
                                                     <div class="card-text texto_p">Categoria : {{$of_st->desc_cat_of_tr}}</div>
                                                     <div class="card-text texto_p">Participante : {{$of_st->nome_part_of_tr}} </div>
                                                     <div class="card-text texto_p">Obs : {{$of_st->obs_of_tr}}</div>   
                                                  @else
                                                     <h6 class="card-title texto-necessidade">Necessidade : {{$of_st->desc_nec}}</h6>
                                                     <div class="card-text texto_p">Categoria : {{$of_st->desc_cat_nec}}</div>
                                                     <div class="card-text texto_p">Participante : {{$of_st->nome_part_nec}} </div>
                                                     <div class="card-text texto_p">Obs : {{$of_st->obs_nec}}</div>   
                                                  @endif
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                            </div>
                        </td>

                        <td>
                          <div class="col">
                                  <div class="card" >

                                    <div class="card-body header-trans">
          
                                        <div class="row align-items-start">
                                            <div class="col">
                                                  <h6 class="card-title">Fluxo : {{$of_st->fluxo}}</h6>
                                                  <div class="card-text texto_p">Quant Fluxo : {{$of_st->quant_moeda}}</div>
                                                  <div class="card-text texto_p">Quant Oferta : {{$of_st->quant_of}}</div>
                                                  @if($of_st->fluxo == 'troca')
                                                      <div class="card-text texto_p">Quant Troca : {{$of_st->quant_of_tr}}</div>
                                                  @else
                                                      <div class="card-text texto_p">Quant Necessidade : {{$of_st->quant_nec}}</div>
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
                            <input value="{{$of_st->id_nec_part}}" name="id_nec_part_t" type="hidden">
                            <input value="{{$of_st->id_of_part}}" name="id_of_part_t" type="hidden"> 
                            <input value="{{$of_st->id_of_tr_part}}" name="id_of_tr_part_t" type="hidden"> 
                            <input value="of" name="origem" type="hidden"> 
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
           {{$of_status->links('layouts.paginationlinks')}}
           
      </div>

    @endif 

<div>

@endsection

