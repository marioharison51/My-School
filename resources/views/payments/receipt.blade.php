<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #0d9488; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { padding: 8px; border-bottom: 1px solid #ddd; text-align: left; }
        .total { font-weight: bold; font-size: 16px; margin-top: 20px; }
        .footer { margin-top: 50px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>My School</h1>
        <p>Reçu de paiement N° {{ $payment->id }}</p>
    </div>

    <table>
        <tr>
            <th>Élève</th>
            <td>{{ $student->full_name }}</td>
        </tr>
        <tr>
            <th>Classe</th>
            <td>{{ $student->current_class }}</td>
        </tr>
        <tr>
            <th>Date du paiement</th>
            <td>{{ $payment->paid_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Méthode</th>
            <td>{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</td>
        </tr>
        @if ($payment->reference)
        <tr>
            <th>Référence</th>
            <td>{{ $payment->reference }}</td>
        </tr>
        @endif
        <tr>
            <th>Enregistré par</th>
            <td>{{ $payment->recordedBy->name ?? '—' }}</td>
        </tr>
    </table>

    <p class="total">Montant payé : {{ number_format($payment->amount, 2) }} Ar</p>

    <div class="footer">
        Document généré le {{ now()->format('d/m/Y à H:i') }} — My School
    </div>
</body>
</html>
