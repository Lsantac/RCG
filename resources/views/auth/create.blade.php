
@extends('master')

@section('content')

<div class="container">

    <form action="{{route('auth.create')}}" method="POST"  class="row g-3" enctype="multipart/form-data">
        @csrf 
        
        <h2 class="texto-participante">Novo Participante</h2> 
        <figure class="figure">
            <img src="/img/logo.jpg" class="figure-img img-fluid rounded imagem-part img-thumbnail" alt="...">
        </figure>
        
        <input class="btn-arquivo" name="part_image" id="part_image" type="file" accept=".jpg,.png,.jpeg">
        
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
        <label for="nome_part" class="form-label">Nome</label>
        <input type="text" id="nome_part" value="{{old('nome_part')}}" name="nome_part" class="form-control @error('nome_part') is-invalid @enderror">
        @error('nome_part')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>

        <br>
        <div class="col-6">
        <label for="email" class="form-label">Email</label>            
        <input type="text" id="email" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" aria-label="email">
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>
        <br>

        <div class="col-md-2">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" value="{{old('senha')}}" class="form-control @error('senha') is-invalid @enderror" id="senha" name="senha">
            @error('senha')
            <div class="invalid-feedback">
                {{$message}}
            </div>      
            @enderror
        </div>
        <div class="col-md-2">
            <label for="senha2" class="form-label">Confirmação da Senha</label>
            <input type="password" value="" class="form-control @error('senha2') is-invalid @enderror" id="senha2" name="senha2">
            @error('senha2')
            <div class="invalid-feedback">
                {{$message}}
            </div>      
            @enderror
        </div>
       
        <div class="col-12">
        <label for="endereco" class="form-label">Endereço</label>
        <input type="text" value="{{old('endereco')}}" class="form-control @error('endereco') is-invalid @enderror" id="endereco" name="endereco" placeholder="Rua, Bairro">
        @error('endereco')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>
        
        <div class="col-md-6">
        <label for="cidade" class="form-label">Cidade</label>
        <input type="text" value="{{old('cidade')}}" class="form-control @error('cidade') is-invalid @enderror" id="cidade" name="cidade">
        @error('cidade')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>

        <div class="col-md-6">
            <label for="pais" class="form-label">Pais</label>
            <input type="text" value="{{old('pais')}}" class="form-control @error('pais') is-invalid @enderror" id="pais" name="pais">
            @error('pais')
            <div class="invalid-feedback">
                 {{$message}}
            </div>      
            @enderror
        </div>

        <div class="col-md-3">
        <label for="estado" class="form-label">Estado</label>
        <select id="estado" value="{{old('estado')}}" name="estado" class="form-select @error('estado') is-invalid @enderror">
            <option selected>{{old('estado')}}</option>
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
        <input type="text" value="{{old('cep')}}" class="form-control @error('cep') is-invalid @enderror" id="cep" name="cep">
        @error('cep')
        <div class="invalid-feedback">
            {{$message}}
        </div>      
        @enderror
        </div>

        <div class="col-md-2">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" value="{{old('latitude')}}" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude">
            @error('latitude')
            <div class="invalid-feedback">
                {{$message}}
            </div>      
            @enderror
        </div>

        <div class="col-md-2">
            <label for="longitude" class="form-label">longitude</label>
            <input type="text" value="{{old('longitude')}}" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude">
            @error('longitude')
            <div class="invalid-feedback">
                {{$message}}
            </div>      
            @enderror
        </div>
        
        <div class="col-12">
        <br>
        <button type="submit" class="btn btn-primary">Confirmar</button>
        </div>
    </form>
</div>

@endsection