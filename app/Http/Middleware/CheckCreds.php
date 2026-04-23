<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCreds
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


         $name = session('name');
        $password = session('password');

         $file = storage_path('app/data/users.json');

           $users = json_decode(file_get_contents($file), true) ?? [];

            $foundUser = false;

    foreach ($users as $user) {
        if ($user['user'] === $name && $user['password'] === $password) {
            $foundUser = true; 
             break; 
        } 


    }

    if  ($foundUser == true)  {

         return $next($request);

    }  

     return redirect('/loggin');

     

    }
}
