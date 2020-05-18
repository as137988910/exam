<?php

namespace App\Http\Middleware;

use Closure;

class Validation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $role=$request->session()->get('role');
//        $role=$_SERVER['REQUEST_URI'];
//        return json_encode($role);
        $role=substr($_SERVER['REQUEST_URI'],1,1);
        if ($request->session()->get('verify')!='yes'){
            switch ($role){
                case 'a':
                    $location='/admin/login';
                    break;
                case 't':
                    $location='/teacher/login';
                    break;
                case 's':
                    $location='/user';
                    break;
                default:
                    $location="/user";
                    break;
            }
//            $content=[
//                'status'=>'0',
//                'message'=>'你还未登录',
//                'location'=>$location
//            ];
            return redirect($location);
//            return response()->json($role)->header('Content-Type','application/json');
        }
        return $next($request);
    }
}
