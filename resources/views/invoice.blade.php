@php
    use App\Helpers\StripeHelper;
@endphp

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Cashier - Invoice</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
</head>
<body>
    
    <div class="d-flex justify-content-between p-3 bg-black">
        <div>
            <p class="text-warning">Laravel Cashier (Stripe)</p>
        </div>
        <div>
            <span>{{ auth()->user()->name }}</span>
            <span class="px-3">|</span>
            <a href="{{ route('logout') }}">Logout</a>
        </div>
    </div>

    <div class="text-center mt-5">
        <p class="display-6">Nota Fiscal!</p>
        <p><a href="{{ route('dashboard'); }}">Voltar</a></p>
    </div>

    <hr>

    <div class="container">

        <div class="max-w-3xl mx-auto bg-white text-dark shadow p-4 rounded-xl mt-8">
            <h1 class="text-2xl font-bold mb-4">Nota Fiscal de Serviço Eletrônica (NFS-e)</h1>
        
            <div class="mb-4">
                <strong>Número da Fatura:</strong> {{ $invoice->number }}<br>
                <strong>Status:</strong> {{ ucfirst($invoice->status) }}<br>
                <strong>Data de Emissão:</strong> {{ \Carbon\Carbon::createFromTimestamp($invoice->created)->format('d/m/Y H:i') }}
            </div>
        
            <div class="mb-4">
                <strong>Cliente:</strong> {{ $invoice->customer_email ?? auth()->user()->email }}<br>
                <strong>Valor:</strong> {{ StripeHelper::formatCurrency($invoice->amount_paid) }}
            </div>
        
            <hr class="my-4">
        
            <h2 class="text-lg font-semibold mb-2">Serviços</h2>
        
            <ul class="list-disc pl-5">
                @foreach ($invoice->lines->data as $item)
                    @php
                        $priceId = $item->price->id ?? null;
            
                        $planLabel = StripeHelper::getPlanLabel($item->price->id);
            
                        $amount = StripeHelper::formatCurrency($item->amount);
                    @endphp
            
                    <li>{{ $item->quantity }} × {{ $item->description }} - {{ $planLabel }} - R$ {{ $amount }}</li>
                @endforeach
            </ul>
        
            <div class="mt-6">
                <a href="{{ $invoice->hosted_invoice_url }}" target="_blank" class="text-blue-600 underline btn btn-success btn-sm">
                    Ver versão oficial da Stripe
                </a>
            </div>
        </div>
      
    </div>

    <hr>   

</body>
</html>