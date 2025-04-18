<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>NFS-e - {{ $invoice->number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .box { margin-bottom: 10px; }
        .section-title { font-weight: bold; margin-bottom: 5px; }
        .item-list { margin-left: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Nota Fiscal de Serviço Eletrônica (NFS-e)</h2>
        <small>Documento gerado automaticamente</small>
    </div>

    <div class="box">
        <div class="section-title">Dados da Fatura</div>
        <p><strong>Número:</strong> {{ $invoice->number }}</p>
        <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
        <p><strong>Data de Emissão:</strong> {{ \Carbon\Carbon::createFromTimestamp($invoice->created)->format('d/m/Y H:i') }}</p>
    </div>

    <div class="box">
        <div class="section-title">Cliente</div>
        <p><strong>Email:</strong> {{ $invoice->customer_email ?? auth()->user()->email }}</p>
        <p><strong>Valor Total:</strong> R$ {{ number_format($invoice->amount_paid / 100, 2, ',', '.') }}</p>
    </div>

    <div class="box">
        <div class="section-title">Serviços Prestados</div>
        <ul class="item-list">
            @foreach ($invoice->lines->data as $item)
                <li>{{ $item->description }} — R$ {{ number_format($item->amount / 100, 2, ',', '.') }}</li>
            @endforeach
        </ul>
    </div>

    <div class="box" style="margin-top: 40px;">
        <p><small>Este documento é uma representação da fatura do Stripe adaptada ao formato NFS-e brasileira. Não possui valor fiscal oficial.</small></p>
    </div>
</body>
</html>