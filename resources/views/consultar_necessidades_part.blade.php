@extends('master')

@section('content')

<div class="container">

    <h2>Necessidades do Participante</h2> 
    <h5>{{$part->nome_part}}</h5> 
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

    <form class="row g-3" method="GET" action="{{route('consultar_necessidades_part')}}">

          @csrf
     
          <div class="col-sm-7">
               <input class="form-control texto_p" name="consulta_nec_part" value="{{Session::get('criterio_nec_part')}}" placeholder="Digite palavras para consulta..." type="search">
               <input name="id_part" type="hidden" value="{{$part->id}}"> 
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          <!--<a class="btn btn btn-redes bi-snow" type="button"> Incluir Rede</a> -->
          
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-incluir-necessidades btn-sm bi-arrow-up-circle-fill" data-bs-toggle="modal" data-bs-target="#Incluirnecessidade">
            Incluir Necessidade
          </button>
          <button type="button" class="btn btn-criar-necessidades btn-sm bi-arrow-up-circle-fill" data-bs-toggle="modal" data-bs-target="#Novanecessidade">
            Criar novo tipo de Necessidade
          </button>
        </div>
        
    </form>

    <form action="{{route('incluir_necessidades_part')}}" method="post">

      @csrf
      
          <!-- Modal Incluir necessidade-->
          <div class="modal fade" id="Incluirnecessidade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Incluir Necessidade de : {{$part->nome_part}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                      <div class="modal-body">
                        <div class="mb-3">

                          <input value="{{$part->id}}" name="id_part" type="hidden">
                          
                          <label for="exampleFormControlInput1" class="form-label">Selecione um tipo de necessidade</label>
                          <select type="text" name="id_nec" id="exampleFormControlInput1" class="form-select" aria-label="Default select example" required>
                            <option value = ""></option>
                            @foreach ($necs as $nec)
                              <option value="{{$nec->id}}"> 
                                    {{$nec->descricao}} 
                              </option>
                            @endforeach
                          </select>
                          <br>

                          <label for="data_nec" class="form-label">Data</label>
                          <input type="date" class="form-control" id="data_nec" name="data_nec" required>
                          <br>

                          <label for="quant_nec" class="form-label">Quantidade</label>
                          <input type="number" step="0.010" class="form-control" id="quant_nec" name="quant_nec" required>

                          <br>

                          <label for="obs_nec" class="form-label">Observações</label>
                          <textarea type="text" class="form-control" id="obs_nec" name="obs_nec"></textarea>
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

    <form action="{{route('nova_necessidade')}}" method="post">
      
      @csrf

    <!-- Modal Criar Nova necessidade -->
    <div class="modal fade" id="Novanecessidade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Criar novo tipo de Necessidade</h5>
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

    @if (isset($necps)) 

    <table class="table table-sm">
        <thead>
          <tr>
            <th scope="col" class="texto_p">Descrição</th>
            <th scope="col" class="texto_p">Data</th>
            <th scope="col" class="texto_p">Quant</th>
            <th scope="col" class="texto_p">Unidade</th>
            <th scope="col" colspan="2" class="texto_p pcenter">Transações</th>
            <th class="texto_p" >Ações</th>
          </tr>
        </thead>

        <tbody>
          @if (count($necps)>0)

              @foreach($necps as $necp)
                <div>
                  <tr>

                    <td>
                      <div class="card " style="width: 40rem;">
                        <div class="card-body">
                          <h5 class="card-title">Necessidade : {{$necp->desc_nec}}</h5>
                          <h6 class="card-subtitle mb-2 text-muted">Categoria : {{$necp->desc_cat}} </h6>
                          <p class="card-text">Obs : {{$necp->obs}}</p>
                          <!--<a href="#" class="card-link">Card link</a>
                          <a href="#" class="card-link">Another link</a>-->
                        </div>
                      </div>
                    </td>

                    <!--<td class="texto_p">{{$necp->desc_nec}}</td>
                    <td class="texto_p">{{$necp->desc_cat}}</td>-->
                    <td class="texto_p">
                        @php
                          $date = new DateTime($necp->data);
                          echo $date->format('d-m-Y');
                        @endphp
                    </td>
                    <td class="texto_p">{{$necp->quant}}</td>
                    <td class="texto_p">{{$necp->desc_unid}}</td>

                    <td>
                      <form action="" method="post">
                            @csrf 
                            
                            <button type="submit" class="btn btn-sm btn-mensagem bi-arrow-repeat texto_p">
                              Mensagens <span class="badge sugestao-of-nec"> </span>                              
                                       
                            </button>

                            <input value="{{$part->id}}" name="id_part_t" type="hidden">
                            <input value="{{$necp->id_nec_part}}" name="id_nec_part_t" type="hidden">
                            
                      </form>
                    </td>

                    <td>
                      <form action="{{route('trans_necessidades_part')}}" method="post">
                            @csrf 
                            <!--<button type="submit" class="btn btn-sm btn-transacao bi-arrow-down-up texto_p"> Transação</button>-->
                            
                            <button type="submit" class="btn btn-sm btn-transacao bi-arrow-down-up texto_p">Sugestões
                                    <span class="badge sugestao-of-nec">
                                      {{App\Http\Controllers\NecessidadesController::verifica_sugestoes_nec($part->id,$necp->desc_cat,$necp->desc_nec,$necp->obs,1)}}
                                    </span>
                            </button>

                            <input value="{{$part->id}}" name="id_part_t" type="hidden">
                            <input value="{{$necp->id_nec_part}}" name="id_nec_part_t" type="hidden">
                            
                      </form>
                    </td>


                    <td>
                        <button class="btn btn-editar btn-sm bi bi-pencil texto_p" type="submit" data-bs-toggle="modal" data-bs-target="#Editarnecessidade-{{$necp->id_nec_part}}"> Editar</button>

                        <form action="{{route('altera_necessidade_part')}}" method="post">
                          @csrf 
                            <!-- Modal Alterar necessidade-->
                            <div class="modal fade" id="Editarnecessidade-{{$necp->id_nec_part}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Alterar Necessidade de : {{$part->nome_part}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                        <div class="modal-body">
                                          <div class="mb-3">
                                            <input value="{{$part->id}}" name="id_part" type="hidden">
                                            <input value="{{$necp->id_nec_part}}" name="id_nec_part" type="hidden">
                                            
                                            <label for="FormControl_id_nec" class="form-label">Selecione um tipo de Necessidade</label>
                                            <select type="text" name="id_nec" id="FormControl_id_nec" class="form-select" aria-label="Default select example" required>
                                              <option value="{{$necp->id_nec}}" selected>{{$necp->desc_nec}}</option>
                                              @foreach ($necs as $nec)
                                                <option value="{{$nec->id}}"> 
                                                      {{$nec->descricao}} 
                                                </option>
                                              @endforeach
                                            </select>
                                            <br>
                  
                                            <label for="data_nec" class="form-label">Data</label>
                                            <input type="date" value="{{$necp->data}}"  class="form-control" id="data_nec" name="data_nec" required>
                                            <br>
                  
                                            <label for="quant_nec" class="form-label">Quantidade</label>
                                            <input type="number" step="0.010" value="{{$necp->quant}}" class="form-control" id="quant_nec" name="quant_nec" required>
                  
                                            <br>
                  
                                            <label for="obs_nec" class="form-label">Observações</label>
                                            <textarea type="text" class="form-control" id="obs_nec" name="obs_nec" value="">{{$necp->obs}}</textarea>
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
                        <button class="btn btn-danger btn-sm bi bi-trash texto_p" type="button" data-bs-toggle="modal" data-bs-target="#ModalExcluinecessidade-{{$necp->id_nec_part}}" >Excluir</button>

                        <form class="" action="/deleta_necessidade_part/{{$necp->id_nec_part}}" method="POST">
                              @csrf
                              @method('DELETE')
                          
                              <!-- Modal -->
                              <div class="modal fade" id="ModalExcluinecessidade-{{$necp->id_nec_part}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Confirma Exclusão da necessidade "{{$necp->desc_nec}}" para {{$part->nome_part}} ?</h5>
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
              <td>Nenhum registro encontrado</td>
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

      <div class="pagination">
           {{$necps->links('layouts.paginationlinks')}}
           
      </div>

    @endif 

<div>

@endsection


