<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantesController;
use App\Http\Controllers\RedesController;
use App\Http\Controllers\mapsController;
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\NecessidadesController;
use App\Http\Controllers\TransacoesController;
use App\Http\Controllers\UserAuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/home', function () {
    return view('home');
});

/*Autenticações, login e logout */

Route::post('login',[UserAuthController::class,'login'])->name('auth.login');
Route::post('create',[UserAuthController::class,'create'])->name('auth.create');
Route::delete('/logout',  [UserAuthController::class,'logout'])->name('auth.logout');
Route::any('mudasenha',  [UserAuthController::class,'alterpass'])->name('auth.alterpass');
Route::any('resetasenha',  [UserAuthController::class,'resetpass'])->name('auth.resetpass');
Route::post('senhaok',  [UserAuthController::class,'alterpassok'])->name('auth.alterpassok');
Route::post('resetsenhaok',  [UserAuthController::class,'resetpassok'])->name('auth.resetpassok');

Route::get('/novo_participante', function () {
    return view('auth.create');
});

Route::any('alterpass', function () {
    return view('auth.alterpass');
});
Route::any('resetpass', function () {
    return view('auth.resetpass');
});

Route::get('/', function () {
    return view('auth.login');
});

/*Participantes*/
Route::get('/participantes', [ParticipantesController::class,'show_none'])->middleware('islogged');
Route::get('/consulta',  [ParticipantesController::class,'query'])->name('procura');
Route::post('/participantes', [ParticipantesController::class,'store']);
Route::get('/alterar_participantes/{id}',  [ParticipantesController::class,'show']);
Route::get('/consultar_participante/{id}',  [ParticipantesController::class,'query_details']);
Route::post('/alterar_participantes/{id}',  [ParticipantesController::class,'update'])->middleware('islogged');
Route::delete('/participantes/{id}',  [ParticipantesController::class,'destroy']);

/*Ofertas*/
Route::get('/ofertas',  [OfertasController::class,'show_none'])->middleware('islogged');
Route::get('/consultar_ofertas',  [OfertasController::class,'consultar_ofertas'])->name('consultar_ofertas');
Route::get('/consultar_ofertas_part',  [OfertasController::class,'consultar_ofertas_part'])->name('consultar_ofertas_part');
Route::get('/ofertas_part/{id}',  [OfertasController::class,'show_ofertas_part'])->name('show_ofertas_part');
Route::post('incluir_ofertas_part',  [OfertasController::class,'incluir_ofertas_part'])->name('incluir_ofertas_part');
Route::delete('/deleta_oferta_part/{id}',  [OfertasController::class,'deleta_oferta_part'])->name('deleta_oferta_part');
Route::post('nova_oferta',  [OfertasController::class,'nova_oferta'])->name('nova_oferta');
Route::post('altera_oferta_part',  [OfertasController::class,'altera_oferta_part'])->name('altera_oferta_part');

/*Necessidades*/
Route::get('/necessidades',  [NecessidadesController::class,'show_none'])->middleware('islogged');
Route::get('/consultar_necessidades',  [NecessidadesController::class,'consultar_necessidades'])->name('consultar_necessidades');
Route::get('/consultar_necessidades_part',  [NecessidadesController::class,'consultar_necessidades_part'])->name('consultar_necessidades_part');
Route::get('/necessidades_part/{id}',  [NecessidadesController::class,'show_necessidades_part'])->name('show_necessidades_part');
Route::post('incluir_necessidades_part',  [NecessidadesController::class,'incluir_necessidades_part'])->name('incluir_necessidades_part');
Route::delete('/deleta_necessidade_part/{id}',  [NecessidadesController::class,'deleta_necessidade_part'])->name('deleta_necessidade_part');
Route::post('nova_necessidade',  [NecessidadesController::class,'nova_necessidade'])->name('nova_necessidade');
Route::post('altera_necessidade_part',  [NecessidadesController::class,'altera_necessidade_part'])->name('altera_necessidade_part');

/*Transações*/
Route::get('/trans_ofertas_part',  [TransacoesController::class,'trans_ofertas_part'])->name('trans_ofertas_part');
Route::get('/trans_trocas_part',  [TransacoesController::class,'trans_trocas_part'])->name('trans_trocas_part');
Route::post('/trans_necessidades_part',  [TransacoesController::class,'trans_necessidades_part'])->name('trans_necessidades_part');
Route::post('/consultar_trans_nec_part',  [TransacoesController::class,'consultar_trans_nec_part'])->name('consultar_trans_nec_part');
Route::post('/consultar_trans_of_part',  [TransacoesController::class,'consultar_trans_of_part'])->name('consultar_trans_of_part');
Route::get('/mens_transacoes_part',  [TransacoesController::class,'mens_transacoes_part'])->name('mens_transacoes_part');
Route::get('/incluir_mens_trans',  [TransacoesController::class,'incluir_mens_trans'])->name('incluir_mensagem');
Route::get('/finalizar_trans',  [TransacoesController::class,'finalizar_trans'])->name('finalizar_transacao');

/*Redes*/
Route::get('/consulta_redes',  [RedesController::class,'query_redes'])->name('consulta_redes');
Route::delete('/deleta_rede_part/{id}',  [RedesController::class,'deleta_rede_part'])->name('deleta_rede_part');
Route::get('/redes_part/{id}',  [RedesController::class,'show_redes'])->name('procura_redes_part');
Route::post('incluir_redes_part',  [RedesController::class,'incluir_redes_part'])->name('incluir_redes_part');
Route::post('nova_rede',  [RedesController::class,'nova_rede'])->name('nova_rede');

/*Mapas*/
Route::post('/mostramapa/{id}',[mapsController::class,'query_mapa'])->name('query_mapa');
Route::get('/mostramapa/{id}',[mapsController::class,'query_mapa'])->name('query_mapa_get');
Route::post('/mostra_varios_parts',[mapsController::class,'mostra_varios_parts'])->name('mostra_varios_parts');
Route::get('/geocode', function ()
{
    return view('geocode');
});