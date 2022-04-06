
@extends('master')

@section('content')

    <div class="container">

        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">

            
            <div class="carousel-inner">
                
                <div class="carousel-item active">
                     <h1 style="text-align: center; color:blue;">{{$ident->nome_ident}}</h1>

                                <img src="/img/imagem2.jpg" class="d-block" 
                                
                                style="width:60vmax; display: block;
                                margin-left: auto;
                                margin-right: auto;" alt="...">
                </div>


              <div class="carousel-item">
                <h1 style="text-align: center; color:blue;">{{$ident->nome_ident}}</h1>
                <img src="/img/imagem6.webp" class="d-block" 

                style="width: 60vmax;height: 45vmax;
                 margin-left: auto;
                margin-right: auto;"
                 alt="...">

              </div>

              <div class="carousel-item">
                <h1 style="text-align: center; color:blue;">{{$ident->nome_ident}}</h1>
                <img src="/img/imagem9.jpg" class="d-block" 

                style="width:60vmax; height:auto; display: block;
                margin-left: auto;
                margin-right: auto;" alt="...">

              </div>

              <div class="carousel-item">
                <h1 style="text-align: center; color:blue;">{{$ident->nome_ident}}</h1>
                <img src="/img/imagem8.jpg" class="d-block" 
                
                style="width:60vmax; display: block;
                margin-left: auto;
                margin-right: auto;" alt="...">
              </div>

             

              <div class="carousel-item">
                <h1 style="text-align: center; color:blue;">{{$ident->nome_ident}}</h1>
                <img src="/img/imagem3.jpg" class="d-block" 
                
                style="width:60vmax; display: block;
                margin-left: auto;
                margin-right: auto;" alt="...">
              </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
            
            

        
      
    </div>

   
@endsection