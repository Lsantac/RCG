@extends('master')

@section('content')

<div class="container">

    <h2 class="texto-unidade">Unidades</h2> 
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

    <form class="row g-3" method="GET" action="consulta_unidades">

          @csrf
     
          <div class="col-sm-8">
               <input class="form-control texto_p" id="consulta"  name="consulta" value="{{Session::get('criterio')}}" type="search">
               <input name="id_logado" type="hidden" value="{{Session::get('id_logado')}}"> 
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          <!--<a class="btn btn btn-redes bi-snow" type="button"> Incluir Rede</a> -->
          
          <!-- Button trigger modal -->
          
          <button type="button" class="btn btn-unidade btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdropNovaUnidade">
            Criar Nova Unidade
          </button>
        </div>
        
    </form>
    

    <form action="{{route('nova_unidade')}}" method="post">
      
      @csrf

    <!-- Modal Criar Nova unidade -->
    <div class="modal fade" id="staticBackdropNovaUnidade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Criar Nova Unidade</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <div class="modal-body">
               
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Descrição</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="descricao" required></textarea>
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

    @if (isset($uns)) 

    <table class="table table-sm texto_m">
        <thead>
          <tr>
            <th scope="col">Descrição</th>
            <th scope="col">Dt Criação</th>

            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @if (count($uns)>0)

              @foreach($uns as $un)
                <div>
                  <tr>
                    
                    <td>{{$un->descricao}}</td>
                    <td>
                      @if($un->dt_criacao)
                          @php
                              $date = new DateTime($un->dt_criacao);
                              echo $date->format('d-m-Y');
                          @endphp
                       @endif
                    </td>
                    <td>
                      <button class="btn btn-danger btn-sm bi bi-trash" type="button" data-bs-toggle="modal" data-bs-target="#ModalExcluiUnidade-{{$un->id}}" >Excluir</button>

                      <form class="" action="/deleta_unidade/{{$un->id}}" method="POST">
                          @csrf
                          @method('DELETE')
                      
                          <!-- Modal -->
                          <div class="modal fade" id="ModalExcluiUnidade-{{$un->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirma Exclusão da Unidade "{{$un->descricao}}" ?</h5>
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
           {{$uns->links('layouts.paginationlinks')}}
           
      </div>

    @endif 
  </div>

@endsection


