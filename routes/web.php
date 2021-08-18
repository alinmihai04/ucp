<?php

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

//Route::get('/1234', 'GroupController@migrate_raport');

Route::middleware('2fa')->group(function() {
    Route::get('/', 'MainController@home')->middleware('2fa');
    Route::get('/online', 'MainController@online');
    Route::get('/staff', 'MainController@staff');
    Route::get('/search', 'MainController@search');
    Route::get('/bids', 'MainController@bids');
    Route::get('/beta', 'MainController@beta');
    Route::get('/ban', 'MainController@banlist');

    Route::get('/admin/resetraport', function () {
        DB::table('f_members')->update(['process_date' => 0]);
        App\Task::process_raports();
        session()->flash('success', 'Rapoarte resetate!');
        return redirect('/');
    });

    Route::get('/admin/grouplevel/{group}', 'AdminController@viewGrouplevel')->middleware('auth')->middleware('admin5');
    Route::get('/admin/groupslots/{group}', 'AdminController@viewGroupslots')->middleware('auth')->middleware('admin5');
    Route::post('/admin/groupslots/{group}', 'AdminController@processGroupslots')->middleware('auth')->middleware('admin5');
    Route::post('/admin/grouplevel/{group}', 'AdminController@processGrouplevel')->middleware('auth')->middleware('admin5');

    Route::post('/search', 'MainController@searchPost');

    // image headers
    Route::get('/map/{x}/{y}', 'MapController@mapPage');
    Route::get('/viewmap/{x}/{y}', 'MapController@renderMap');

    Route::get('/userbar/{name}', 'UserController@userbar');

    // user routes
    Route::get('/profile/{user}', 'UserController@profile');
    Route::get('/decon/{user}', 'UserController@decon')->middleware('auth');;
    Route::get('/user/hours/{user}', 'UserController@hours')->middleware('auth')->middleware('admin');
    Route::get('/user/changemail/{user}', 'UserController@viewChangemail')->middleware('auth');
    Route::post('/user/changemail/done/{user}', 'UserController@processChangemail')->middleware('auth');
    Route::get('/notifications', 'UserController@allnotifications')->middleware('auth');
    Route::get('/shownskin/{show}', 'UserController@shownskin')->middleware('auth');


    Route::get('/account/security/code', 'SecurityController@process2fa')->middleware('auth');
    Route::get('/account/security', 'SecurityController@view2fa')->middleware('auth');
    Route::post('/account/security/disable', 'SecurityController@disable2fa')->name('2fa_disable')->middleware('auth');

    // group routes
    Route::get('/leader', 'GroupController@leader')->middleware('auth');

    Route::get('/group/list', 'GroupController@list');
    Route::get('/group/members/{group}', 'GroupController@members');
    Route::get('/group/logs/{group}', 'GroupController@logs');
    Route::get('/group/complaints/{group}', 'GroupController@complaints');
    Route::get('/group/applications/{group}', 'GroupController@viewApplications');
    Route::get('/group/app/{group}', 'GroupController@appStatus');

    Route::get('/group/skins/{group}', 'AdminController@group_skins')->middleware('auth')->middleware('owner');
    Route::post('/group/skins/add/{group}', 'AdminController@group_skins_add')->middleware('auth')->middleware('owner');
    Route::get('/group/skins/remove/{group}/{skin}', 'AdminController@group_skins_remove')->middleware('auth')->middleware('owner');

    Route::get('/raport', 'GroupController@myraport');
    Route::get('/raport/{group}', 'GroupController@raport');
    Route::get('/raport/add/{group}', 'GroupController@raportAdd');
    Route::get('/raport/edit/{group}', 'GroupController@raportEdit');
    Route::get('/raport/edit/{group}/{rank}', 'GroupController@raportEdit');
    Route::get('/goal/edit/{goal}', 'GroupController@goalEdit');
    Route::get('/goal/delete/{goal}', 'GroupController@goalDelete');

    Route::post('/raport/add/{group}', 'GroupController@raportAddPost');
    Route::post('/raport/hours', 'GroupController@raportHours');
    Route::post('/goal/add/{group}/{rank}', 'GroupController@goalAdd');
    Route::post('/goal/edit/{goal}/{group}', 'GroupController@goalEditPost');

    // admin actions
    Route::get('/admin', 'AdminController@controlPanel')->middleware('auth')->middleware('admin');
    Route::get('/admin/historyfh/{fh}', 'AdminController@historyFh')->middleware('auth')->middleware('admin');
    Route::get('/admin/refresh/{user}', 'AdminController@refresh')->middleware('auth')->middleware('admin');
    Route::get('/admin/fnc/{user}', 'AdminController@fnc')->middleware('auth')->middleware('admin5');
    Route::get('/admin/hidefh/{user}/{fh}', 'AdminController@hidefh')->middleware('auth')->middleware('admin5');
    Route::get('/admin/editfh/{user}/{fh}', 'AdminController@editfh')->middleware('auth')->middleware('admin5');
    Route::get('/admin/unban/{user}', 'AdminController@unban')->middleware('auth')->middleware('admin5');
    Route::get('/admin/note/{user}', 'AdminController@note')->middleware('auth')->middleware('owner');
    Route::get('/admin/func/{user}', 'AdminController@func')->middleware('auth')->middleware('owner');
    Route::get('/admin/clearcache', 'AdminController@clearcache')->middleware('auth')->middleware('owner');
    Route::get('/admin/makebeta/{user}', 'AdminController@beta')->middleware('auth')->middleware('owner');
    Route::get('/admin/remove/{user}', 'AdminController@remove')->middleware('auth')->middleware('owner');
    Route::get('/admin/givepp/{user}', 'AdminController@givepp')->middleware('auth')->middleware('owner');
    Route::post('/admin/givepp/{user}', 'AdminController@giveppPost')->middleware('auth')->middleware('owner');
    Route::get('/admin/money/{user}', 'AdminController@money')->middleware('auth')->middleware('owner');
    Route::post('/admin/money/{user}', 'AdminController@moneyEdit')->middleware('auth')->middleware('owner');
    Route::get('/admin/support/{level}/{user}', 'AdminController@support')->middleware('auth')->middleware('owner');

    Route::post('/admin/fnc/{user}', 'AdminController@fncPost')->middleware('auth')->middleware('admin5');
    Route::post('/admin/editfh/{user}/{fh}', 'AdminController@editfhPost')->middleware('auth')->middleware('admin5');
    Route::post('/admin/note/{user}', 'AdminController@notePost')->middleware('auth')->middleware('owner');
    Route::post('/admin/func/{user}', 'AdminController@funcPost')->middleware('auth')->middleware('owner');

    // logs
    Route::get('/logs/player/{user}', 'LogsController@player')->middleware('auth')->middleware('admin');
    Route::get('/logs/important/{user}', 'LogsController@important')->middleware('auth')->middleware('admin');
    Route::get('/logs/chat/{user}', 'LogsController@chat')->middleware('auth')->middleware('owner');
    Route::get('/logs/vehicle/{vehicle}', 'LogsController@vehicle')->middleware('auth')->middleware('admin');
    Route::get('/logs/clan/{clan}', 'LogsController@clan');
    Route::get('/logs/raport', 'LogsController@raport');

    // clan routes
    Route::get('/clan/view/{clan}', 'ClanController@view');
    Route::get('/clan/register', 'ClanController@register')->middleware('auth');
    Route::post('/clan/register', 'ClanController@registerPost')->middleware('auth');
    Route::get('/clan', 'ClanController@list');
    Route::get('/clan/delete/{clan}', 'ClanController@delete')->middleware('auth');
    Route::post('/clan/edit/{clan}', 'ClanController@edit');

    // stats routes
    Route::any('/topplayers', 'StatsController@top');
    Route::any('/houses', 'StatsController@houses');
    Route::any('/businesses', 'StatsController@businesses');

    // topics
    Route::get('/mycomplaints', 'TopicsController@myComplaints')->middleware('auth');
    Route::any('/complaints', 'TopicsController@complaintsList');
    Route::any('/complaints/{type}', 'TopicsController@complaintsListFilter');
    Route::any('/complaint/view/{topic}', 'TopicsController@view');
    Route::any('/complaint/create', function() {
        session()->flash('success', 'Pentru a-i face reclamatie cuiva, scrie-i nick-ul mai jos, apoi apasa butonul `Reclama player` de pe profilul lui.<br>To report a player, search for his profile, than click the `make a complaint` button');
        return redirect('/search');
    });
    Route::get('/complaint/create/{user}', 'TopicsController@complaintCreate')->middleware('auth');
    Route::post('/complaint/money/{topic}', 'AdminController@complaintMoney');

    Route::get('/complaint/reason/{topic}', 'TopicsController@viewReasonchange')->middleware('auth')->middleware('admin');
    Route::post('/complaint/reason/change/{topic}', 'TopicsController@processReasonchange')->middleware('auth')->middleware('admin');

    Route::post('/complaint/create/{user}', 'TopicsController@complaintCreatePost')->middleware('auth');
    Route::post('/complaint/respond/{topic}', 'TopicsController@complaintRespond')->middleware('auth')->middleware('admin');
    Route::post('/complaint/fw/{topic}', 'TopicsController@giveFactionWarn')->middleware('auth');

    // posts

    Route::post('/post/reply/{topic}', 'PostController@add')->middleware('auth');
    Route::any('/post/delete/{post}', 'PostController@delete')->middleware('auth');


});
Route::get('/loadnotifications', 'UserController@notifications')->middleware('auth');
Route::post('/2fa','SecurityController@enable2fa')->name('enable2fa')->middleware('auth');
Route::post('/2fa/login','SecurityController@validateCode')->middleware('auth');
Auth::routes();

