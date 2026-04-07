<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Balance de Comprobación</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .company-name { font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .report-title { font-size: 14px; margin-top: 5px; color: #555; }
        .report-date { font-size: 11px; margin-top: 5px; color: #777; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f2f2f2; border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 10px; }
        td { border: 1px solid #eee; padding: 5px; text-align: left; font-size: 10px; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .level-1 { font-weight: bold; background-color: #f9f9f9; }
        .level-2 { padding-left: 20px; font-weight: bold; }
        .level-3 { padding-left: 30px; font-style: italic; }
        .level-4 { padding-left: 40px; }
        .footer { margin-top: 30px; text-align: right; font-size: 9px; color: #777; }
        .total-row { border-top: 2px solid #444; background-color: #eee; font-weight: bold; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $empresa->nombre }}</div>
        <div class="report-title">Balance de Comprobación de Sumas y Saldos</div>
        <div class="report-date">Desde el {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Código</th>
                <th width="35%">Cuenta Contable</th>
                <th width="12%" class="text-right">Saldo Inicial</th>
                <th width="12%" class="text-right">Debe</th>
                <th width="12%" class="text-right">Haber</th>
                <th width="14%" class="text-right">Saldo Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
            <tr class="level-{{ $cuenta['nivel'] }} {{ $cuenta['nivel'] <= 2 ? 'text-bold' : '' }}">
                <td style="padding-left: {{ ($cuenta['nivel'] - 1) * 10 }}px">{{ $cuenta['codigo'] }}</td>
                <td>{{ $cuenta['nombre'] }}</td>
                <td class="text-right">{{ number_format($cuenta['saldo_inicial'], 2) }}</td>
                <td class="text-right">{{ number_format($cuenta['debe'], 2) }}</td>
                <td class="text-right">{{ number_format($cuenta['haber'], 2) }}</td>
                <td class="text-right">{{ number_format($cuenta['saldo_final'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2" class="text-right">TOTALES GENERALES</td>
                <td>-</td>
                <td class="text-right">{{ number_format($totales_generales['debe'], 2) }}</td>
                <td class="text-right">{{ number_format($totales_generales['haber'], 2) }}</td>
                <td>-</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Generado el {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
