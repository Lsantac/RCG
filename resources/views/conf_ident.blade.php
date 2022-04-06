@extends('master')

@section('content')

<div class="container">
    
    <br>

    <div class="card" style="width:40vmax;margin:auto;">
        <div class="card-body">
          
          <h3 class="texto-m text-center" style="color:dodgerblue;">Identidade do Sistema</h3> 
          
          <form class="row g-3 needs-validation" novalidate action="" method="post" enctype="multipart/form-data">
            <div class="col-md-12">
              <label for="validationNomeSis" class="form-label">Nome</label>
              <input type="text" class="form-control" id="validationNomeSis" value="{{$ident->nome_ident}}" required>
              <div class="valid-feedback">
                Parece Bom!
              </div>
              <br>
            </div>

            <div class="row">
                <div class="col-3">
                    <figure class="figure">
                          <img id="logo-sis" src="/img/{{$ident->logo}}" class="figure-img img-fluid imagem-sis img-thumbnail" value="">
                    </figure>
                </div>

                <div class="col-9" style="align-self: flex-end;">
                    <label for="sel_img" class="form-label texto_m">Selecionar Logo</label>
                     <input  name="sel_img" id="sel_img" type="file" accept=".jpg,.png,.jpeg" onchange ="mostra_imagem(this, 'inclusao',0)" class="form-control form-control-sm @error('sel_img') is-invalid @enderror" >
                     <label class="form-label red-message">{{Session::get('fail image')}}</label>
                 </div>
          
            </div>
           
            <div class="col-12 text-center">
              <button class="btn btn-primary" type="submit">Confirmar</button>
            </div>
          </form>
        </div>
      </div>
    
</div>

<script>
     
    function mostra_imagem(input,$modo,$id_ident){

             if (input.files && input.files[0]) {

               var reader = new FileReader();

               reader.onload = function (e) {
                     if($modo == 'inclusao'){
                       $('#logo-sis').attr('src', e.target.result);
                     }else{
                       if($modo == 'editar'){
                          $('#logo-sis-' + $id_ident).attr('src', e.target.result);
                          
                       }
                     }
                     
               };
               reader.readAsDataURL(input.files[0]);
               
             }

    }

 </script>

@endsection


