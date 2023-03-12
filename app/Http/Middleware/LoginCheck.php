<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $IlluminateResponse = 'Illuminate\Http\Response';
        $SymfonyResopnse = 'Symfony\Component\HttpFoundation\Response';

        

        if (!session()->has('loggedInUser') && 
            $request->path() != '/') 
        {
            return redirect('/');
        }

        if (session()->has('loggedInUser') && 
            $request->path() == '/') 
        {
            return back();
        }

        // if (session()->has('loggedInUser') &&
        //     $request->path() == '/forgot-password')
        // {
        //     return back();
        // }


        if($response instanceof $IlluminateResponse) {
            return $response
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
            
        }
        if($response instanceof $SymfonyResopnse) {
            try {
                return $response
                ->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                ->headers->set('Pragma', 'no-cache')
                ->headers->set('Expires', 'Sat 01 Jan 1970 00:00:00 GMT');
            } catch (\ErrorException $e) {
                // Handle the error gracefully
                if (strpos($e->getMessage(), 'Attempt to read property "headers" on null') !== false) {
                    // Ignore the error and pass
                    return;
                } 
                // else {
                    // Log the error or do something else
                    // Log::error($e->getMessage());
                // }
            }
            
        }

        
    }



}
