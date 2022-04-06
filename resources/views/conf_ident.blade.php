@extends('master')

@section('content')

<div class="container">
    
    <br>

    <div class="card" style="width:40vmax;margin:auto;">
        <div class="card-body">
          
          <h3 class="texto-m text-center" style="color:dodgerblue;">Identidade do Sistema</h3> 
          
          <form class="row g-3 needs-validation" novalidate>
            <div class="col-md-12">
              <label for="validationNomeSis" class="form-label">Nome</label>
              <input type="text" class="form-control" id="validationNomeSis" value="" required>
              <div class="valid-feedback">
                Parece Bom!
              </div>
              <br>
            </div>

            <div class="col-12 text-center">
                <figure class="figure">
                      <img id="logo-sis" src="/img/logo.jpg" class="figure-img img-fluid imagem-sis img-thumbnail ">
                </figure>
            </div>
            

            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Logo</label>
                <input type="file" class="form-control" id="inputGroupFile01" required>
            </div>
           
            <div class="col-12 text-center">
              <button class="btn btn-primary" type="submit">Confirmar</button>
            </div>
          </form>
        </div>
      </div>
    
</div>

@endsection


