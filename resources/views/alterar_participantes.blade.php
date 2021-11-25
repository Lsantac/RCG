
@extends('master')

@section('content')

<div class="container">
    <form action="/alterar_participantes/{{$participante->id}}" method="POST"  class="row g-3" enctype="multipart/form-data">

        @csrf 

        <h2 class="texto-participante">Alterar Participante</h2> 

        <figure class="figure">

            @if(!@empty($participante->imagem))
                <img src="/uploads/participantes/{{Session('imagem_logado')}}" class="imagem-part rounded-pill">
            @else
                <img src="/img/logo.jpg" class="figure-img img-fluid rounded-pill imagem-part img-thumbnail ">
            @endif 

            <!--<img src="/uploads/participantes/{{$participante->imagem}}" class="figure-img img-fluid rounded imagem-part img-thumbnail" alt="...">-->
        </figure>

        <div class="row">
            <label for="part_image" class="form-label">Alterar imagem</label>
            <input class="form-control form-control-sm @error('part_image') is-invalid @enderror" name="part_image" id="part_image" type="file" accept=".jpg,.png,.jpeg">
            <label class="form-label red-message">{{Session::get('fail image')}}</label>
        </div>

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
        
        <div class="col-6">
        <label for="Nome" class="form-label">Nome</label>
        <input type="text" value = "{{$participante->nome_part}}" id="Nome" name="nome_part" class="form-control @error('nome_part') is-invalid @enderror"  aria-label="First name">
        @error('nome_part')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>

        <br>
        <div class="col-6">
        <label for="email" class="form-label">Email</label>            
        <input type="text" name="email" value = "{{$participante->email}}" id="email"   class="form-control @error('email') is-invalid @enderror" aria-label="inputEmail">
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>
        <br>
      
        <div class="col-12">
        <label for="endereco" class="form-label">Endereço</label>
        <input type="text" name="endereco" value = "{{$participante->endereco}}" class="form-control @error('endereco') is-invalid @enderror" id="endereco"  placeholder="Rua, Bairro">
        @error('endereco')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>
        
        <div class="col-md-6">
        <label for="cidade" class="form-label">Cidade</label>
        <input type="text" name="cidade" value = "{{$participante->cidade}}" class="form-control @error('cidade') is-invalid @enderror" id="cidade" >
        @error('inputCidade')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>

        <div class="col-md-6">
        <label for="pais" class="form-label">Pais</label>
        <input type="text" name="pais" value = "{{$participante->pais}}" class="form-control @error('pais') is-invalid @enderror" id="pais" >
         @error('pais')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>

        <div class="col-md-3">
        <label for="estado" class="form-label">Estado</label>
        <select id="estado" name="estado" class="form-select @error('estado') is-invalid @enderror">
            <option selected>{{$participante->estado}}</option>
            <option>SP</option>
            <option>MG</option>
            <option>RS</option>
            <option>BA</option>
            <option>PR</option>
            <option>SC</option>
            <option>GO</option>
            <option>MT</option>
            <option>AM</option>
            <option>RN</option>
            <option>PA</option>
            <option>RO</option>
            <option>RR</option>
            <option>RJ</option>
            <option>PB</option>
        </select>
        @error('estado')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror

        </div>
        <br>

        <div class="col-md-2">
        <label for="cep" class="form-label">Cep</label>
        <input type="text" name="cep" value = "{{$participante->cep}}" class="form-control @error('cep') is-invalid @enderror" id="cep" >
        @error('cep')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>

        <div class="col-md-2">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" value="{{$participante->latitude}}" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude">
            @error('latitude')
            <div class="invalid-feedback">
                {{$message}}
            </div>      
            @enderror
        </div>

        <div class="col-md-2">
            <label for="longitude" class="form-label">longitude</label>
            <input type="text" value="{{$participante->longitude}}" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude">
            @error('longitude')
            <div class="invalid-feedback">
                {{$message}}
            </div>      
            @enderror
        </div>
        
        <div class="col-12">
        <br>
        <button type="submit" style="margin-right: 50px" class="btn btn-primary texto_p">Confirmar Dados</button>
        
        <a type="button" href="/ofertas_part/{{$participante->id}}" class="btn btn-ofertas bi-arrow-up-circle-fill texto_m"> Ofertas</a>   
        <a type="button" href="/necessidades_part/{{$participante->id}}" class="btn btn-necessidades bi-arrow-down-circle-fill texto_m"> Necessidades</a>   
        <a type="button" href="/transacoes_part/{{$participante->id}}" class="btn btn-transacao bi-arrow-down-up texto_m"> Transações</a>   
        <a type="button" href="/redes_part/{{$participante->id}}" class="btn btn-redes bi-snow texto_m"> Redes</a>   
        <a type="button" href="/mostramapa/{{$participante->id}}"  class="btn btn-mapa bi-globe texto_m"> Mapa</a>    
        <!--<a type="button" href="/geocode" class="btn btn-mapa-geral bi-globe texto_p"> Teste Geocode</a>-->
        
        </div>
        
    </form>
</div>

@endsection