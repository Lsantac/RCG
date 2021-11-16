@extends('master')

@section('content')

<div class="container-fluid">

    <h2>Participantes</h2> 
    <br>
    <div class='results'>
        @if(Session::get('fail_mapa'))
            <div class="alert alert-danger texto_p">
                {{Session::get('fail_mapa')}}
            </div>
        @endif
    </div>
    
    <form  class="d-flex" method="GET" action="{{route('procura')}}">

        @csrf

        <input class="form-control me-2 texto_m" name="consulta" value="{{Session::get('criterio_cons_part')}}" type="search" placeholder="Digite palavras para consulta..." aria-label="Consultar">
        
        <!--<select id="inputRede" name="rede" class="form-select me-2">
          <option selected>Procurar na Rede...</option>
          
        </select>-->
        
        <input class="form-control me-2 texto_m" list="rede-list" name="consulta_redes" value="{{Session::get('criterio_cons_rede')}}" id="consulta_redes" type="search" placeholder="Consulta por Rede...">
        <datalist id="rede-list">
                  @foreach ($redes as $rede)
                           <option value="{{ $rede->nome }}"> 
                                  {{ $rede->nome }} 
                           </option>
                  @endforeach
        </datalist> 
        
        <button class="btn btn btn-primary me-2 texto_p" type="submit">Procurar</button>
            
    </form>

    <!--<form class="d-flex" action="" method="post">
      @csrf
      <button type="submit" class="btn btn-mapa-geral btn-sm bi-globe no-margin">
        Mapa Geral
      </button>

    </form>-->
    

    <br>
    @if (isset($part)) 

    <table class="table table-sm texto_p">
        <thead>
          <tr class="">
            <th scope="col">Foto</th>
            <th scope="col">Nome</th>
            <th scope="col">Endereço</th>
            <th scope="col">Cidade</th>
            <th scope="col">Estado</th>
            <th scope="col">Pais</th>
            <th scope="col">Cep</th>
            <th scope="col">Email</th>
            
            @if(Session::get('cons_rede'))
               <th scope="col">Rede</th>
            @endif

            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @if (count($part)>0)

              @foreach($part as $p)
                <div>
                  <tr>
                    <!--<th scope="row">{{$p->id}}</th>-->
                    <td>
                      
                      @if(!@empty($p->imagem))
                          <img src="/uploads/participantes/{{$p->imagem}}" class="imagem-header">
                      @else
                          <img src="/img/logo.jpg" class="imagem-header">
                      @endif 

                    </td>
                    
                    <td>{{$p->nome_part}}</td>
                    <td>{{$p->endereco}}</td>
                    <td>{{$p->cidade}}</td>
                    <td>{{$p->estado}}</td>
                    <td>{{$p->pais}}</td>
                    <td>{{$p->cep}}</td>
                    <td>{{$p->email}}</td>

                    @if(Session::get('cons_rede'))
                       <td>{{$p->nome_rede}}&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    @endif
                    
                    <td>
                      <div class="row">
                      <form class="col no-margin" action="/participantes/{{$p->id}}" method="POST">
                          <!--<a href="/alterar_participantes/{{$p->id}}" class="btn btn-warning btn-sm"><i class="bi bi-pencil">Alterar</i></a>
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger btn-sm bi bi-trash" type="submit">Excluir</button>  -->
                          
                          <a href="/consultar_participante/{{$p->id}}" class="btn btn-violeta btn-sm bi-card-text btn-detalhes texto_p"> Detalhes</a> 
                          
                       </form>   
                  
                       <form class="col" action="/mostramapa/{{$p->id}}" method="post">

                        @csrf

                        @if($p->latitude<>null)
                              <button type="submit" class="btn btn-mapa btn-sm bi-globe texto_p">
                        @else
                              <button type="submit" class="btn btn-mapa-disable btn-sm bi-globe texto_p">
                        @endif
                               Mapa
                              </button>

                        </form>

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
            <td></td>
          </tr>    
          @endif 

        </tbody>
      </table>

      <div class="pagination">
           {{$part->links('layouts.paginationlinks')}}
           
      </div>

    @endif 

</div>

@endsection

