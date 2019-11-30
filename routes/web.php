<?php
use Illuminate\Http\Request;
use \App\User;
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

Route::get('/', function () {

    return redirect()->route('projects.index');
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('/users', function(){
    $users = \App\User::all();
    return $users;
});*/

Route::post('/delete', function(Request $request) {
    $id = Auth::id();
    /*$subs = \App\Subscription::where('user_id', $id)->get();

    foreach($subs as $sub) {
        $sub->delete();
    }
    $subs =
    $projects = \App\Project::where('creator_id', $id)->get();

    foreach($projects as $project) {
        $project->delete();
    }
    return $projects;*/
    $user = User::findOrFail($id)->delete();

    return redirect()->route('home');
})->middleware('auth')->name('user.delete');

Route::resource('/projects', 'ProjectController')->middleware('auth');

Route::resource('/subscriptions', 'SubscriptionController')->middleware('auth');
