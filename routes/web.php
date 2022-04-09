<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantesController;
use App\Http\Controllers\RedesController;
use App\Http\Controllers\mapsController;
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\NecessidadesController;
use App\Http\Controllers\TransacoesController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\IniciaController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\MoedasController;
use App\Http\Controllers\UnidadesController;
use App\Http\Controllers\IdentController;

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

/*Tela Inicial */
Route::get('/home', [IniciaController::class,'home'])->middleware('islogged');
Route::get('/', [IniciaController::class,'ident']);
Route::get('/inicio', [IniciaController::class,'inicio'])->middleware('islogged');
Route::get('/cons_trans_ofertas_part/{status}/{id_part}', [IniciaController::class,'cons_trans_ofertas_part'])->middleware('islogged');;
Route::get('/cons_trans_necessidades_part/{status}/{id_part}', [IniciaController::class,'cons_trans_necessidades_part'])->middleware('islogged');;

/*Configura Identidade */
Route::get('/identidade', [IdentController::class,'conf_ident'])->middleware('islogged');
Route::post('/altera_ident', [IdentController::class,'altera_ident'])->name('altera_ident');

/*Autenticações, login e logout */

Route::post('login',[UserAuthController::class,'login'])->name('auth.login');
Route::post('create',[UserAuthController::class,'create'])->name('auth.create');
Route::delete('/logout',[UserAuthController::class,'logout'])->name('auth.logout');
Route::any('mudasenha',[UserAuthController::class,'alterpass'])->name('auth.alterpass');
Route::any('resetasenha',[UserAuthController::class,'resetpass'])->name('auth.resetpass');
Route::post('senhaok',[UserAuthController::class,'alterpassok'])->name('auth.alterpassok');
Route::post('resetsenhaok',[UserAuthController::class,'resetpassok'])->name('auth.resetpassok');

Route::get('/novo_participante', function () {
    return view('auth.create');
});

Route::any('alterpass', function () {
    return view('auth.alterpass');
});
Route::any('resetpass', function () {
    return view('auth.resetpass');
});

/*Route::get('/', function () {
    //return view('auth.login');
    return view('home');
});*/

Route::get('/login', function () {
    return view('auth.login');
    
});

/*Participantes*/
Route::get('/participantes', [ParticipantesController::class,'show_none'])->middleware('islogged');
Route::get('/consulta',  [ParticipantesController::class,'query'])->name('procura')->middleware('islogged');
Route::post('/participantes', [ParticipantesController::class,'store'])->middleware('islogged');;
Route::get('/alterar_participantes/{id}',  [ParticipantesController::class,'show'])->middleware('islogged');;
Route::get('/consultar_participante/{id}',  [ParticipantesController::class,'query_details'])->middleware('islogged');;
Route::post('/alterar_participantes/{id}',  [ParticipantesController::class,'update'])->middleware('islogged');
Route::delete('/participantes/{id}',  [ParticipantesController::class,'destroy'])->middleware('islogged');;

/*Ofertas*/
Route::get('/ofertas',  [OfertasController::class,'show_none'])->middleware('islogged');
Route::get('/consultar_ofertas',  [OfertasController::class,'consultar_ofertas'])->name('consultar_ofertas')->middleware('islogged');;
Route::get('/consultar_ofertas_part',  [OfertasController::class,'consultar_ofertas_part'])->name('consultar_ofertas_part')->middleware('islogged');
Route::get('/ofertas_part/{id}',  [OfertasController::class,'show_ofertas_part'])->name('show_ofertas_part')->middleware('islogged');
Route::post('incluir_ofertas_part',  [OfertasController::class,'incluir_ofertas_part'])->name('incluir_ofertas_part');
Route::delete('/deleta_oferta_part/{id}',  [OfertasController::class,'deleta_oferta_part'])->name('deleta_oferta_part');
Route::post('nova_oferta',  [OfertasController::class,'nova_oferta'])->name('nova_oferta');
Route::post('altera_oferta_part',  [OfertasController::class,'altera_oferta_part'])->name('altera_oferta_part');

/*Necessidades*/
Route::get('/necessidades',  [NecessidadesController::class,'show_none'])->middleware('islogged');
Route::get('/consultar_necessidades',  [NecessidadesController::class,'consultar_necessidades'])->name('consultar_necessidades')->middleware('islogged');
Route::get('/consultar_necessidades_part',  [NecessidadesController::class,'consultar_necessidades_part'])->name('consultar_necessidades_part')->middleware('islogged');
Route::get('/necessidades_part/{id}',  [NecessidadesController::class,'show_necessidades_part'])->name('show_necessidades_part')->middleware('islogged');
Route::post('incluir_necessidades_part',  [NecessidadesController::class,'incluir_necessidades_part'])->name('incluir_necessidades_part');
Route::delete('/deleta_necessidade_part/{id}',  [NecessidadesController::class,'deleta_necessidade_part'])->name('deleta_necessidade_part');
Route::post('nova_necessidade',  [NecessidadesController::class,'nova_necessidade'])->name('nova_necessidade');
Route::post('altera_necessidade_part',  [NecessidadesController::class,'altera_necessidade_part'])->name('altera_necessidade_part');

/*Transações*/
Route::get('/trans_ofertas_part',  [TransacoesController::class,'trans_ofertas_part'])->name('trans_ofertas_part')->middleware('islogged');
Route::get('/trans_trocas_part',  [TransacoesController::class,'trans_trocas_part'])->name('trans_trocas_part')->middleware('islogged');
Route::get('/trans_necessidades_part',  [TransacoesController::class,'trans_necessidades_part'])->name('trans_necessidades_part')->middleware('islogged');

Route::get('/consultar_trans_nec_part',  [TransacoesController::class,'consultar_trans_nec_part'])->name('consultar_trans_nec_part')->middleware('islogged');
Route::get('/consultar_trans_of_part',  [TransacoesController::class,'consultar_trans_of_part'])->name('consultar_trans_of_part')->middleware('islogged');
Route::get('/consultar_trans_trocas_part',  [TransacoesController::class,'consultar_trans_trocas_part'])->name('consultar_trans_trocas_part')->middleware('islogged');

Route::get('/mens_transacoes_part',  [TransacoesController::class,'mens_transacoes_part'])->name('mens_transacoes_part')->middleware('islogged');

Route::get('/incluir_mens_trans',  [TransacoesController::class,'incluir_mens_trans'])->name('incluir_mensagem')->middleware('islogged');
Route::post('/altera_mensagem',  [TransacoesController::class,'altera_mensagem'])->name('altera_mensagem')->middleware('islogged');
Route::delete('/deleta_mensagem',  [TransacoesController::class,'deleta_mensagem'])->name('deleta_mensagem')->middleware('islogged');

Route::get('/finalizar_trans',  [TransacoesController::class,'finalizar_trans'])->name('finalizar_transacao')->middleware('islogged');
Route::get('/cancelar_transacao',  [TransacoesController::class,'cancelar_transacao'])->name('cancelar_transacao')->middleware('islogged');

/*Redes*/
Route::get('/consulta_redes',  [RedesController::class,'query_redes'])->name('consulta_redes')->middleware('islogged');
Route::delete('/deleta_rede_part/{id}',  [RedesController::class,'deleta_rede_part'])->name('deleta_rede_part');
Route::get('/redes_part/{id}',  [RedesController::class,'show_redes'])->name('procura_redes_part');
Route::post('incluir_redes_part',  [RedesController::class,'incluir_redes_part'])->name('incluir_redes_part');
Route::post('nova_rede',  [RedesController::class,'nova_rede'])->name('nova_rede');

/*Categorias*/
Route::get('/consulta_categorias',  [CategoriasController::class,'query_categorias'])->name('consulta_categorias')->middleware('islogged');
Route::get('/categorias',  [CategoriasController::class,'show_categorias'])->name('show_categorias')->middleware('islogged');
Route::delete('/deleta_categoria/{id}',  [CategoriasController::class,'deleta_categoria'])->name('deleta_categoria');
Route::post('nova_categoria',  [CategoriasController::class,'nova_categoria'])->name('nova_categoria');

/*Unidades*/
Route::get('/consulta_unidades',  [UnidadesController::class,'query_unidades'])->name('consulta_unidades')->middleware('islogged');
Route::get('/unidades',  [UnidadesController::class,'show_unidades'])->name('show_unidades')->middleware('islogged');
Route::delete('/deleta_unidade/{id}',  [UnidadesController::class,'deleta_unidade'])->name('deleta_unidade');
Route::post('nova_unidade',  [UnidadesController::class,'nova_unidade'])->name('nova_unidade');

/*Moedas*/
Route::get('/consulta_moedas',  [MoedasController::class,'query_moedas'])->name('consulta_moedas')->middleware('islogged');
Route::get('/moedas',  [MoedasController::class,'show_moedas'])->name('show_moedas')->middleware('islogged');
Route::delete('/deleta_moeda/{id}',  [MoedasController::class,'deleta_moeda'])->name('deleta_moeda');
Route::post('nova_moeda',  [MoedasController::class,'nova_moeda'])->name('nova_moeda');
Route::get('/consulta_saldos/{id}',  [MoedasController::class,'consulta_saldos'])->name('consulta_saldos')->middleware('islogged');

/*Mapas*/
Route::post('/mostramapa/{id}',[mapsController::class,'query_mapa'])->name('query_mapa')->middleware('islogged');
Route::get('/mostramapa/{id}',[mapsController::class,'query_mapa'])->name('query_mapa_get')->middleware('islogged');
Route::post('/mostra_varios_parts',[mapsController::class,'mostra_varios_parts'])->name('mostra_varios_parts')->middleware('islogged');
Route::get('/geocode', function ()
{
    return view('geocode');
});



