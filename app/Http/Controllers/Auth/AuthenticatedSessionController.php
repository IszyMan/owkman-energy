<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $userId = auth()->id();

        if(session()->has('cart')) {

            $sessionCart = session()->get('cart');

            foreach($sessionCart as $item) {

                $existing = \App\Models\Cart::where('user_id', $userId)
                    ->where('product_id', $item['product_id'])
                    ->first();

                if($existing) {

                    $existing->increment('quantity', $item['quantity']);

                } else {

                    \App\Models\Cart::create([
                        'user_id' => $userId,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity']
                    ]);
                }
            }

            session()->forget('cart');
        }

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    
}
