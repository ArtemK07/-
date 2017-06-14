<?php
/**
 * Created by PhpStorm.
 * User: Yuriy.M
 * Date: 26.05.2017
 * Time: 14:48
 */

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Validator;
use Closure;


class SignupMailVerification
{
    public function handle($request, Closure $next)
    {
        $validator = Validator::make(['email' => $request->old('email')],
            ['email' =>  'email',
            ]
        );
        if ($validator->fails()) {
            return redirect('signup');
        }
        return $next($request);
    }
}