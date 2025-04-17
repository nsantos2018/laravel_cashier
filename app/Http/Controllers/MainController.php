<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function loginPage()
    {
        return view('login');
    }

    public function loginSubmit($id)
    {
        // direct login
        $user = User::findOrFail($id);
        if($user)
        {
            auth()->login($user);
            //echo "Logado com Sucesso! <br> " . auth()->user()->name;
            return redirect()->route('plans');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function plans()
    {
        //return view('plans');

        $prices = [
            "month" => Crypt::encryptString( env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_PRICE_MONTHLY') ),
            "one_year" => Crypt::encryptString( env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_PRICE_ONE_YEAR') ),
            "three_year" => Crypt::encryptString( env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_PRICE_THREE_YEAR') ),
        ];

        return view('plans', compact('prices'));

    }

    public function planSelected($id)
    {
        // check if $id is valid
        $plan = Crypt::decryptString($id);

        if(!$plan){
            return redirect()->route('plans');
        }

        $data = explode('|', $plan);
        //echo "Product ID " . $data[0] . "<br>";
        //echo "Price ID " . $data[1] . "<br>";
        $product_id = $data[0];
        $price_id = $data[1];

        return auth()->user()
            ->newSubscription($product_id, $price_id)
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('plans'),
            ]);
    }

    public function subscriptionSuccess()
    {
        //echo "Subscrição realizada com sucesso!";
        return view('subscription_success');
    }

    public function dashboard()
    {
        $data = [];

        // check the expiration of subscription
        $timestamp = auth()->user()->subscription(env('STRIPE_PRODUCT_ID'))
            ->asStripeSubscription()
            ->current_period_end;

        $data['subscription_end'] = date('d/m/Y H:i:s', $timestamp);

        return view('dashboard', $data);
    }


}
