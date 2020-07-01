<?php

namespace App\Http\Middleware;

use App\Account;
use Closure;

class CheckAccount
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $accountId = $request->header('x-account-id');

        if (empty($accountId)) {
            return response()->json(["errors" => "Account ID is required"], 404);
        }

        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(["errors" => 'Account not found'], 404);
        }

        return $next($request);
    }
}
