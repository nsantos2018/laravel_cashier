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

    <div class="container">

        <div class="alert alert-secondary" role="alert">

            <h2 class="text-xl font-bold mb-4">Histórico de Faturas</h2>

            <table class="table w-full table-auto mb-8 bg-dark w-100 p-2">
                <thead>
                    <tr>
                        <th class="text-left">Número</th>
                        <th class="text-left">Valor</th>
                        <th class="text-left">Data</th>
                        <th class="text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->number }}</td>
                            <td>R$ {{ number_format($invoice->amount_paid / 100, 2, ',', '.') }}</td>
                            <td>{{ $invoice->date()->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('invoice.show', $invoice->id) }}" class="text-blue-600 underline mr-2 btn btn-info btn-sm">Ver NFS-e</a>
                                <a href="{{ route('invoice.download', $invoice->id) }}" class="text-green-600 underline btn btn-success btn-sm">Baixar PDF</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>