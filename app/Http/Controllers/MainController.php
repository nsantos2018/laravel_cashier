<?php

namespace App\Http\Controllers;

use App\Helpers\StripeHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Product;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $subscription = auth()->user()
            ->subscription(env('STRIPE_PRODUCT_ID'))
            ->asStripeSubscription();

        // 1. Data de expiração
        $timestamp = $subscription->current_period_end;
        //$data['subscription_end'] = date('d/m/Y H:i:s', $timestamp);
        $data['subscription_end'] = StripeHelper::formatDate($timestamp);

        // 2. Price ID do plano
        $priceId = $subscription->items->data[0]->price->id;

        // 3. Inicializa Stripe        
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // 4. Busca os dados do Price e Product
        $price = Price::retrieve($priceId);
        $product = Product::retrieve($price->product);

        // 5. Preenche dados
        $data['plan_name'] = $product->name;
        //$data['plan_amount'] = number_format($price->unit_amount / 100, 2, ',', '.'); // em reais (R$)
        $data['plan_amount'] = StripeHelper::formatCurrency($price->unit_amount);

        // Identifica o tipo do plano contratado
        $planLabel = StripeHelper::getPlanLabel($priceId);

        $data['plan_label'] = $planLabel;

        // 6. Faturas
        $invoices = auth()->user()->invoices();
        $data['invoices'] = $invoices;

        /*
        if( count($invoices) > 0 ){
            $invoice = auth()->user()->invoices()->first();
            //dd($invoice);
        }
        */

        return view('dashboard', $data);
    }

    public function invoiceDownload($id)
    {
        //return auth()->user()->downloadInvoice($id);

        return auth()->user()->downloadInvoice($id,[
            'vendor' => 'Your Company',
            'product' => 'Your Product',
            'street' => 'Main Str. 1',
            'location' => '2000 Antwerp, Belgium',
            'phone' => '+32 499 00 00 00',
            'email' => 'info@example.com',
            'url' => 'https://example.com',
            'vendorVat' => 'BE123456789',
        ]);
    }

    public function showInvoice($invoiceId)
    {
        $invoice = auth()->user()->findInvoice($invoiceId); // Cashier busca com segurança

        if (!$invoice) {
            abort(404);
        }

        $stripeInvoice = $invoice->asStripeInvoice();

        return view('invoice', [
            'invoice' => $stripeInvoice
        ]);
    }


    public function downloadInvoicePdf($invoiceId)
    {
        $invoice = auth()->user()->findInvoice($invoiceId);

        if (!$invoice) {
            abort(404);
        }

        $stripeInvoice = $invoice->asStripeInvoice();

        $pdf = Pdf::loadView('invoice_pdf', [
            'invoice' => $stripeInvoice
        ]);

        $fileName = 'nfse-' . $invoice->number . '.pdf';

        return $pdf->download($fileName);
    }


}
