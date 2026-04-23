<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
Route::get('/', function () {
    return view('welcome');
});


Route::get('/andrew', function() {
    return view('andrewtest');
});

Route::get('/helloworld', function() {
    return view('helloworld');
});

Route::get('/mypage', function() {
    return view('mypage'); // loads resources/views/mypage.blade.php
});

Route::get('/home', function() {
  
    $n = "ANDREW";
    $name = $n;
   
   //return  $n;
   return view('home', ['name' => $name]);
});



Route::get('/json', function() {
    

    return response()->json(
        [ 'name' =>'Andy' ,
          'age' => 25]
    );
});


Route::get('/download', function() {

 return response()->download(storage_path('app/files/download'));
  
});



Route::get('/text', function() {

 return response('Hello Andrew!', 200) ->header('Content-Type', 'text/plain');
  
});


Route::get('/form1', function() {
    $name1 = "NEW NAME";
    return view('form1',['name1' => $name1 ]); // loads resources/views/mypage.blade.php
});


Route::post('/processform', function (Request $request) {

    // ✅ Validation
    $request->validate([
        'name1' => 'required|min:3'
    ], [
        'name1.min' => 'Name must be at least 3 characters long.',
    ]);

    // ✅ Get input safely
    $name1 = $request->input('name1');

    return view('form1', ['name1' => $name1]); 
}); 



Route::get('/test', function () {
    return "Route reached";
});


Route::get('/andrewx', function () {
    return "ANDREWX";
})->middleware('simplemsg');




Route::get('/names/{name?}', function (Request $request, $name = 'Guest') {
    return "Hello, $name";
});

Route::get('/test-middleware', function() {
    $kernel = app(\App\Http\Kernel::class);
    dd($kernel->getRouteMiddleware());
});

Route::get('/HELLO', function () {
    return "HELLO";
})->middleware('Hellomiddleware');


Route::get('/TESTNEW', function () {
    return "TEST NEW" ;
}) ->middleware('Testnew'); 


use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);

use App\Http\Controllers\TestController;

Route::get('/tests', [TestController::class, 'index']);
*/


Route::get('/', function() {
    return view('loggin');
});

Route::get('/loggin', function() {
return view('loggin'); 
});

Route::get('/newregistration', function() {

     return view('newregistration'); 
})->middleware('CheckCreds');


Route::get('/loggout', function() {

     return view('loggin'); 
});




Route::post('/newemployee',  function (Request $request)  {

 $file = storage_path('app/data/users.json');

    // 1. Get form values
    $name = $request->input('name');
    $password = $request->input('password');
    $role = $request->input('role');

    // 2. Load existing users
    $users = file_exists($file)
        ? json_decode(file_get_contents($file), true)
        : [];

    // 3. Create new user
    $newUser = [
        "user" => $name,
        "password" => $password, // ⚠️ plain text (demo only)
        "role" => $role,
        "permissions" => [
            "view" => $request->has('view'),
            "create" => $request->has('create'),
            "edit" => $request->has('edit'),
            "delete" => $request->has('delete')
        ]
    ];

    // 4. Append user
    $users[] = $newUser;

    // 5. Save back to JSON
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

    return redirect()->back();
})->middleware('CheckCreds');


 Route::post('/processloggin', function (Request $request) {

    $name = $request->input('name');
    session(['name' => $name]);
    $password = $request->input('password');

     session(['password' => $password]);

    $file = storage_path('app/data/users.json');

    if (!file_exists($file)) {
        dd("NOT FOUND AT: " . $file);
    }

    $users = json_decode(file_get_contents($file), true) ?? [];

    // 🔍 SEARCH USER
    $foundUser = null;

    foreach ($users as $user) {
        if ($user['user'] === $name && $user['password'] === $password) {
            $foundUser = $user;
            break;
        }
    }

    if (!$foundUser) {
        return back()->with('error', 'Invalid credentials');
    }

    // ✅ IF FOUND → LOAD DASHBOARD
    return view('dashboard', compact('users'));
})->middleware('CheckCreds');

Route::get('/logout', function () {

    session()->flush(); // clear session if you add login later

    return redirect('/loggin');
});



Route::get('/deleteUser', function() {

 return "delete employee"; 
})->middleware('CheckCreds');

Route::get('/users', function() {


     $file = storage_path('app/data/users.json');

       $users = file_exists($file) ? json_decode(file_get_contents($file), true): [];

 return view('dashboard', compact('users'));
})->middleware('CheckCreds');




Route::get('/approved', function() {


     $file = storage_path('app/data/approved.json');

       $approvedleaves = file_exists($file) ? json_decode(file_get_contents($file), true): [];

 return view('approved', compact('approvedleaves'));
})->middleware('CheckCreds');



Route::get('/leave',  function (Request $request) { 

 $file = storage_path('app/data/pendingleave.json');

    if (!file_exists($file)) {
        dd("NOT FOUND AT: " . $file);
    }

    $pendingleaves = json_decode(file_get_contents($file), true);

    return view('leave', compact('pendingleaves')); 
    
})->middleware('CheckCreds');

