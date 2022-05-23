
@extends('master')

@section('content')

<div class="container">

    <form action="{{route('auth.create')}}" method="POST"  class="row g-3" enctype="multipart/form-data">
        @csrf

        <h2 class="texto-participante">Novo Participante</h2>
        <div class="row">
            <label for="part_image" class="form-label">
                Foto de perfil
            </label>
            <input id="part_image" accept=".jpg,.png,.jpeg" data-msg-placeholder="Selecione sua foto de perfil"
                name="part_image" type="file" class="file" data-browse-on-zone-click="true"
                >
        </div>
        <!-- <div class="row">
            <div class="col-2" >
                 <figure style="margin: 0 0 0rem;">
                    <img  id="imagem_part" src="/img/logo.jpg" class="figure-img img-fluid rounded imagem-part img-thumbnail" alt="...">
                </figure>
            </div>
            <div class="col-10" style="align-self: flex-end;">
                <input class="btn-arquivo" onchange ="mostra_imagem(this, 'inclusao',0)" name="part_image" id="part_image" type="file" accept=".jpg,.png,.jpeg">
            </div>

        </div> -->

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
            <option>AC</option>
            <option>AL</option>
            <option>AM</option>
            <option>AP</option>
            <option>BA</option>
            <option>CE</option>
            <option>DF</option>
            <option>ES</option>
            <option>GO</option>
            <option>MA</option>
            <option>MG</option>
            <option>MS</option>
            <option>MT</option>
            <option>PA</option>
            <option>PB</option>
            <option>PE</option>
            <option>PI</option>
            <option>PR</option>
            <option>RJ</option>
            <option>RN</option>
            <option>RO</option>
            <option>RR</option>
            <option>RS</option>
            <option>SC</option>
            <option>SE</option>
            <option>SP</option>
            <option>TO</option>
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

        <button type="submit" class="btn btn-primary texto_m">Confirmar</button>
        </div>
    </form>
</div>

<script>

    function mostra_imagem(input,$modo,$id_of_part){

             if (input.files && input.files[0]) {

               var reader = new FileReader();

               reader.onload = function (e) {
                     if($modo == 'inclusao'){
                       $('#imagem_part').attr('src', e.target.result);
                     }else{
                       if($modo == 'editar'){
                          $('#imagem_of_alt-' + $id_of_part).attr('src', e.target.result);

                       }
                     }

               };
               reader.readAsDataURL(input.files[0]);

             }

    }

 </script>

@endsection
