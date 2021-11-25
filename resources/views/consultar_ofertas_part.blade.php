@extends('master')

@section('content')



<div class="container-fluid">

    <h2 class="texto-oferta">Ofertas do Participante</h2> 
    <h5 class="texto-nome-logado">{{$part->nome_part}}</h5> 
    <br>

    <div class='results'>
      @if(Session::get('success'))
          <div class="alert alert-success">
              {{Session::get('success')}}
          </div>
      @endif

      @if(Session::get('fail'))
          <div class="alert alert-danger">
              {{Session::get('fail')}}
          </div>
      @endif

    </div>

    <form class="row g-3" method="get" action="{{route('consultar_ofertas_part')}}">

          @csrf
     
          <div class="col-sm-8">
               <input class="form-control texto_m" name="consulta_of_part" value="{{Session::get('criterio_of_part')}}" placeholder="Digite palavras para consulta..." type="search">
               <input name="id_part" type="hidden" value="{{$part->id}}"> 
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          <!--<a class="btn btn btn-redes bi-snow" type="button"> Incluir Rede</a> -->
          
          <!-- Button trigger modal -->
              
              @if(Session::get('id_logado') == $part->id)  
                <button type="button" class="btn btn-incluir-ofertas btn-sm bi-arrow-up-circle-fill" data-bs-toggle="modal" data-bs-target="#IncluirOferta">
                  Incluir Oferta
                </button>

                <button type="button" class="btn btn-criar-ofertas btn-sm bi-arrow-up-circle-fill" data-bs-toggle="modal" data-bs-target="#NovaOferta">
                  Criar novo tipo de Oferta
                </button>
              @endif 
          
        </div>
        
    </form>

    <form action="{{route('incluir_ofertas_part')}}" method="post">

         @csrf
      
          <!-- Modal Incluir Oferta-->
          <div class="modal fade" id="IncluirOferta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Incluir Oferta de : {{$part->nome_part}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                      <div class="modal-body">
                        <div class="mb-3">

                          <input value="{{$part->id}}" name="id_part" type="hidden">
                          
                          <label for="exampleFormControlInput1" class="form-label">Selecione um tipo de Oferta</label>
                          <select type="text" name="id_of" id="exampleFormControlInput1" class="form-select" aria-label="Default select example" required>
                            <option value = ""></option>
                            @foreach ($ofs as $of)
                              <option value="{{$of->id}}"> 
                                    {{$of->descricao}} 
                              </option>
                            @endforeach
                          </select>
                          <br>

                          <label for="data_of" class="form-label">Data</label>
                          <input type="date" class="form-control" id="data_of" name="data_of" required>
                          <br>

                          <label for="quant_of" class="form-label">Quantidade</label>
                          <input type="number" step="0.010" class="form-control" id="quant_of" name="quant_of" required>

                          <br>

                          <label for="obs_of" class="form-label">Observações</label>
                          <textarea type="text" class="form-control" id="obs_of" name="obs_of" required></textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-sair" data-bs-dismiss="modal">Sair</button>
                      <button type="submit" class="btn btn-primary">Incluir</button>
                    </div>
              </div>
            </div>
          </div>
    </form>

    <form action="{{route('nova_oferta')}}" method="post">
      
      @csrf

    <!-- Modal Criar Nova Oferta -->
    <div class="modal fade" id="NovaOferta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Criar novo tipo de Oferta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <div class="modal-body">
               <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="descricao" required>
              </div>
              <div class="mb-3">
                <label for="categoria" class="form-label">Selecione uma Categoria</label>
                <select type="text" name="categoria" id="categoria" class="form-select" aria-label="Default select example" required>
                  <option value = ""></option>
                  @foreach ($cats as $cat)
                    <option value="{{$cat->id}}"> 
                          {{$cat->descricao}} 
                    </option>
                  @endforeach
                </select>
                <br>
                <label for="unidade" class="form-label">Selecione uma Unidade</label>
                <select type="text" name="unidade" id="unidade" class="form-select" aria-label="Default select example" required>
                  <option value = ""></option>
                  @foreach ($unids as $unid)
                    <option value="{{$unid->id}}"> 
                          {{$unid->descricao}} 
                    </option>
                  @endforeach
                </select>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sair" data-bs-dismiss="modal">Sair</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </div>
      </div>
    </div>

    </form>

    <br>

    @if (isset($ofps)) 

    <table  class="table table-sm">
        <thead style="border-bottom: 1px solid black;">
          <tr>
            <th scope="col" class="texto_p">Descrição</th>
            <!--<th scope="col" class="texto_p">Categoria</th>-->
            <th scope="col" class="texto_p">Data</th>
            <th scope="col" class="texto_p">Quant</th>
            <th scope="col" class="texto_p">Unidade</th>
            <!--<th scope="col" class="texto_p">Observações</th>-->
            <th scope="col" colspan="2" class="texto_p pcenter">Transações</th>
            @if(Session::get('id_logado') == $part->id)  
                <th class="texto_p" >Ações</th>
            @else
                <th class="texto_p" >Status</th>
            @endif

          </tr>
        </thead>

        <tbody>
          @if (count($ofps)>0)

              @foreach($ofps as $ofp)
                <div>
                  <tr>
                    <td>
                      <div class="card" style="width: 40rem;">
                        <div class="card-body">
                          <h5 class="card-title texto-oferta">Oferta : {{$ofp->desc_of}}</h5>
                          <h6 style="color:rgb(4, 97, 97)" class="card-subtitle mb-2">Categoria : {{$ofp->desc_cat}} </h6>
                          <p class="card-text">Obs : {{$ofp->obs}}</p>
                          <!--<a href="#" class="card-link">Card link</a>
                          <a href="#" class="card-link">Another link</a>-->
                        </div>
                      </div>
                    </td>

                    <!--<td class="texto_p">{{$ofp->desc_of}}</td>
                    <td class="texto_p">{{$ofp->desc_cat}}</td>-->
                    <td class="texto_p">
                      @php
                          $date = new DateTime($ofp->data);
                          echo $date->format('d-m-Y');
                       @endphp
                    </td>
                    <td class="texto_p">{{$ofp->quant}}</td>
                    <td class="texto_p">{{$ofp->desc_unid}}</td>
                   
                    <!--<td>
                      <form action="" method="post">
                            @csrf 
                            
                            <button type="submit" class="btn btn-sm btn-mensagem bi-arrow-repeat texto_p">
                              Mensagens <span class="badge sugestao-of-nec"> </span>                              
                                       
                            </button>

                            <input value="{{$part->id}}" name="id_part_t" type="hidden">
                            <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
                            
                      </form>
                    </td> -->

                    <td>
                        <form action="{{route('trans_ofertas_part')}}" method="get">
                              @csrf 
                              <button type="submit" class="btn btn-sm btn-sugestoes bi-arrow-down-up texto_p">
                                Sugestões <span class="badge sugestao-of-nec">
                                          @if(Session::get('id_logado') == $part->id)
                                             {{App\Http\Controllers\OfertasController::verifica_sugestoes_of(Session::get('id_logado'),$ofp->desc_cat,$ofp->desc_of,$ofp->obs,1)}}
                                          @else
                                             {{App\Http\Controllers\OfertasController::verifica_sugestoes_of(Session::get('id_logado'),$ofp->desc_cat,$ofp->desc_of,$ofp->obs,0)}}
                                          @endif
                                          </span>
                              </button>
                              @if(Session::get('id_logado') == $part->id)
                                 <input value="1" name="filtra_id_logado" type="hidden">
                                 <input value="{{$part->id}}" name="id_part_t" type="hidden">   
                                 <input value="" name="nome_part_cab" type="hidden">   
                              @else
                                 <input value="0" name="filtra_id_logado" type="hidden">
                                 <input value="{{Session::get('id_logado')}}" name="id_part_t" type="hidden">
                                 <input value="{{$part->nome_part}}" name="nome_part_cab" type="hidden">   
                              @endif 
                              <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
                        </form>
                    </td>
                    
                    <td>
                        @if(Session::get('id_logado') == $part->id)  
                           <button class="btn btn-editar btn-sm bi bi-pencil texto_p" type="submit" data-bs-toggle="modal" data-bs-target="#EditarOferta-{{$ofp->id_of_part}}">
                            Editar</button>
                        @endif  

                        <form action="{{route('altera_oferta_part')}}" method="post">
                          @csrf 
                            <!-- Modal Alterar Oferta-->
                            <div class="modal fade" id="EditarOferta-{{$ofp->id_of_part}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Alterar Oferta de : {{$part->nome_part}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                        <div class="modal-body">
                                          <div class="mb-3">
                                            <input value="{{$part->id}}" name="id_part" type="hidden">
                                            <input value="{{$ofp->id_of_part}}" name="id_of_part" type="hidden">
                                            
                                            <label for="FormControl_id_of" class="form-label">Selecione um tipo de Oferta</label>
                                            <select type="text" name="id_of" id="FormControl_id_of" class="form-select" aria-label="Default select example" required>
                                              <option value="{{$ofp->id_of}}" selected>{{$ofp->desc_of}}</option>
                                              @foreach ($ofs as $of)
                                                <option value="{{$of->id}}"> 
                                                      {{$of->descricao}} 
                                                </option>
                                              @endforeach
                                            </select>
                                            <br>
                  
                                            <label for="data_of" class="form-label">Data</label>
                                            <input type="date" value="{{$ofp->data}}"  class="form-control" id="data_of" name="data_of" required>
                                            <br>
                  
                                            <label for="quant_of" class="form-label">Quantidade</label>
                                            <input type="number" step="0.010" value="{{$ofp->quant}}" class="form-control" id="quant_of" name="quant_of" required>
                  
                                            <br>
                  
                                            <label for="obs_of" class="form-label">Observações</label>
                                            <textarea type="text" class="form-control" id="obs_of" name="obs_of" value="">{{$ofp->obs}}</textarea>
                                          </div>
                                          
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-sair" data-bs-dismiss="modal">Sair</button>
                                        <button type="submit" class="btn btn-primary">Alterar</button>
                                      </div>
                                </div>
                              </div>
                            </div>
                          </form>
                    </td>
                    <td>
                        @if(Session::get('id_logado') == $part->id)  
                            <button class="btn btn-danger btn-sm bi bi-trash texto_p" type="button" data-bs-toggle="modal" data-bs-target="#ModalExcluiOferta-{{$ofp->id_of_part}}" >
                             Excluir</button>
                        @endif

                        <form class="" action="/deleta_oferta_part/{{$ofp->id_of_part}}" method="POST">
                              @csrf
                              @method('DELETE')
                          
                              <!-- Modal -->
                              <div class="modal fade" id="ModalExcluiOferta-{{$ofp->id_of_part}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Confirma Exclusão da Oferta "{{$ofp->desc_of}}" para {{$part->nome_part}} ?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                   
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Sair</button>
                                      <button type="submit" class="btn btn-danger">Excluir</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </form>
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
           {{$ofps->links('layouts.paginationlinks')}}
           
      </div>

    @endif 

<div>

@endsection


