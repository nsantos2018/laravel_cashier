<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Cashier</title>
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
        <p class="display-6">Dashboard!</p>
    </div>

    <hr>

    <div class="container">

        <div class="alert alert-secondary" role="alert">

            <ul class="list-group list-group-flush">
                <li class="list-group-item">Plano contratado: {{ $plan_name }} ({{ $plan_label }})</li>
                <li class="list-group-item">Valor do Plano: R$ {{ $plan_amount }}</li>
                <li class="list-group-item">Data de Expiração: {{ $subscription_end }}</li>                
            </ul>
           
        </div>
        

        <p>
            Data de expiração do seu plano é em: <strong>{{ $subscription_end }}</strong>
        </p>
    </div>

    <hr>

    @foreach ($invoices as $invoice)
        
        <div class="text-center">
            <a href="{{ route('invoice.download', $invoice->id) }}" class="btn btn-warning">Download PDF</a>
        </div>
        
    @endforeach

</body>
</html>