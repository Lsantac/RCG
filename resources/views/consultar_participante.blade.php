
@extends('master')

@section('content')

<div class="container">
    <form action="/alterar_participantes/{{$participante->id}}" method="POST"  class="row g-3" enctype="multipart/form-data">

        @csrf 

        <h2 class="texto-participante">Detalhes do Participante</h2> 

        <figure class="figure">
            @if(!@empty($participante->imagem))
                <img src="/uploads/participantes/{{$participante->imagem}}" class="imagem-part rounded-pill">
            @else
                <img src="/img/logo.jpg" class="figure-img img-fluid rounded-pill imagem-part img-thumbnail">
            @endif 
        </figure>
        
        <div class="col-6">
        <label for="Nome" class="form-label">Nome</label>
        <input disabled type="text" value = "{{$participante->nome_part}}" id="Nome" name="nome_part" class="form-control"  aria-label="First name">
        
        </div>

        <br>
        <div class="col-6">
        <label for="email" class="form-label">Email</label>            
        <input disabled type="text" name="email" value = "{{$participante->email}}" id="email"   class="form-control" aria-label="inputEmail">
        
        </div>
        <br>
      
        <div class="col-12">
        <label for="endereco" class="form-label">Endereço</label>
        <input disabled type="text" name="endereco" value = "{{$participante->endereco}}" class="form-control" id="endereco"  placeholder="Rua, Bairro">
        
        </div>
        
        <div class="col-md-6">
        <label for="cidade" class="form-label">Cidade</label>
        <input disabled type="text" name="cidade" value = "{{$participante->cidade}}" class="form-control" id="cidade" >
        
        </div>

        <div class="col-md-6">
        <label for="pais" class="form-label">Pais</label>
        <input disabled type="text" name="pais" value = "{{$participante->pais}}" class="form-control" id="pais" >
        
        </div>

        <div class="col-md-3">
        <label for="estado" class="form-label">Estado</label>
        <input disabled type="text" name="estado" value = "{{$participante->estado}}" class="form-control" id="estado" >
        
        </div>
        <br>

        <div class="col-md-2">
        <label for="cep" class="form-label">Cep</label>
        <input disabled type="text" name="cep" value = "{{$participante->cep}}" class="form-control" id="cep" >
        </div>
       
        <div class="md-2">
            <br>
            <a type="button" href="/ofertas_part/{{$participante->id}}" class="btn btn-ofertas bi-arrow-up-circle-fill texto_m"> Ofertas</a>   
            <a type="button" href="/necessidades_part/{{$participante->id}}" class="btn btn-necessidades bi-arrow-down-circle-fill texto_m"> Necessidades</a>   
            <a type="button" href="/transacoes_part/{{$participante->id}}" class="btn btn-transacao bi-arrow-down-up texto_m"> Transações</a>   
            <a type="button" href="/redes_part/{{$participante->id}}" class="btn btn-redes bi-snow texto_m"> Redes</a>   
            <a type="button" href="/mostramapa/{{$participante->id}}"  class="btn btn-mapa bi-globe texto_m"> Mapa</a>  

        </div>
        
    </form>
</div>

@endsection