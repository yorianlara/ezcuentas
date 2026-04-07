<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libro Mayor - {{ $cuenta->nombre }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .company-name { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        .report-title { font-size: 16px; margin-top: 5px; color: #555; }
        .info-grid { width: 100%; margin-bottom: 20px; }
        .info-label { font-weight: bold; width: 15%; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f2f2f2; border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 11px; }
        td { border: 1px solid #eee; padding: 6px; text-align: left; font-size: 11px; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #777; }
        .bg-totals { background-color: #fafafa; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $empresa->nombre }}</div>
        <div class="report-title">Libro Mayor Detallado</div>
    </div>

    <table class="info-grid">
        <tr>
            <td class="info-label" style="border:none">Cuenta:</td>
            <td style="border:none">{{ $cuenta->codigo }} - {{ $cuenta->nombre }}</td>
            <td class="info-label" style="border:none; text-align:right">Rango:</td>
            <td style="border:none; text-align:right">{{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="10%">Fecha</th>
                <th width="15%">Número</th>
                <th width="35%">Concepto</th>
                <th width="13%" class="text-right">Debe</th>
                <th width="13%" class="text-right">Haber</th>
                <th width="14%" class="text-right">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" class="font-bold">SALDO INICIAL AL {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }}</td>
                <td class="text-right">-</td>
                <td class="text-right">-</td>
                <td class="text-right font-bold">{{ number_format($saldo_inicial, 2) }}</td>
            </tr>
            @foreach($movimientos as $mov)
            <tr>
                <td>{{ $mov['fecha'] }}</td>
                <td>{{ $mov['numero'] }}</td>
                <td>{{ $mov['concepto'] }}</td>
                <td class="text-right">{{ number_format($mov['debe'], 2) }}</td>
                <td class="text-right">{{ number_format($mov['haber'], 2) }}</td>
                <td class="text-right">{{ number_format($mov['saldo'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-totals">
                <td colspan="3" class="text-right">TOTALES DEL PERIODO</td>
                <td class="text-right">{{ number_format($total_debe, 2) }}</td>
                <td class="text-right">{{ number_format($total_haber, 2) }}</td>
                <td class="text-right">-</td>
            </tr>
            <tr class="bg-totals">
                <td colspan="5" class="text-right">SALDO FINAL AL {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</td>
                <td class="text-right" style="border-top: 2px double #444">{{ number_format($saldo_final, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Generado el {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
