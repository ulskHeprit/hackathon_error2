<?php

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Subscription;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/sub', function(Request $request) {
   $request->validate([
      'token' => 'required',
      'message' => 'required',
   ]);
   $token = $request->get('token');
   $message = $request->get('message');
   $data = array('name'=>"Oops some error happened", 'body' => $message);

   $project = Project::where('token', $token)->first();

   $subs = Subscription::where('project_id', $project->id)->get();
   foreach ($subs as $sub) {
       $sub->user = User::find($sub->user_id);

       $mes = new \App\Message();
       $mes->project_id = $project->id;
       $mes->message = $message;

       $mes->save();
       Mail::send('email.mail', $data, function($message) use ($sub, $project) {
           $message->to($sub->user->email, 'Tutorials Point')->subject
           ("{$sub->user->name}, some error happened in Project: {$project->name}");
           $message->from('xumuk495.xx@gmail.com', "🚨 {$sub->user->name} ALARM!!! 🚨");
       });

   }
   return "ok";
});
