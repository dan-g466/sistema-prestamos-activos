<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Préstamos - SENA</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            margin: 20px;
            background: white;
        }

        /* Header */
        .header-table { width: 100%; margin-bottom: 20px; }
        .header-title { font-size: 20px; font-weight: bold; color: #00324D; }
        .header-sub   { font-size: 9px; color: #64748b; text-transform: uppercase; margin-top: 4px; }
        .header-sena  { font-size: 16px; font-weight: bold; color: #39A900; text-align: right; }
        .header-date  { font-size: 9px; color: #94a3b8; text-align: right; }
        .divider      { border-top: 3px solid #39A900; margin-bottom: 20px; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table thead tr { background-color: #00324D; color: #ffffff; }
        .data-table thead th { padding: 8px 10px; text-align: left; font-size: 9px; text-transform: uppercase; }
        .data-table tbody tr:nth-child(even) { background-color: #f8fafc; }
        .data-table tbody td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; font-size: 9.5px; }

        .name     { font-weight: bold; color: #00324D; }
        .element  { color: #334155; }
        .date     { color: #64748b; font-family: monospace; }
        .status   { font-weight: bold; text-transform: uppercase; font-size: 8.5px; }

        /* Badges */
        .badge { padding: 3px 8px; border-radius: 4px; font-weight: bold; }
        .b-activo    { background: #dcfce7; color: #166534; }
        .b-devuelto  { background: #f1f5f9; color: #475569; }
        .b-vencido   { background: #fee2e2; color: #991b1b; }

        /* Footer */
        .footer { position: fixed; bottom: 0; width: 100%; border-top: 1px solid #e2e8f0; padding-top: 10px; font-size: 8px; color: #94a3b8; }
        .footer-right { text-align: right; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="header-title">Reporte Mensual de Préstamos</div>
                <div class="header-sub">Control de Actividad — Sistema de Gestión SENA</div>
            </td>
            <td>
                <div class="header-sena">SENA</div>
                <div class="header-date">Generado el {{ now()->format('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>
    <div class="divider"></div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th style="width: 25%">Aprendiz / Usuario</th>
                <th style="width: 30%">Elemento Solicitado</th>
                <th style="width: 15%">Solicitud</th>
                <th style="width: 15%">Devolución</th>
                <th style="width: 10%">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prestamos as $i => $p)
                @php
                    $isVencido = $p->estado === 'Activo' && $p->fecha_devolucion_esperada < now();
                    $statusClass = $isVencido ? 'b-vencido' : ($p->estado === 'Devuelto' ? 'b-devuelto' : 'b-activo');
                    $statusLabel = $isVencido ? 'VENCIDO' : $p->estado;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="name">{{ $p->user->name ?? 'Usuario no encontrado' }}</td>
                    <td class="element">
                        {{ $p->elemento->nombre ?? 'N/A' }}
                        <br><small style="color:#94a3b8">{{ $p->elemento->codigo_sena ?? '' }}</small>
                    </td>
                    <td class="date">{{ $p->created_at->format('d/m/Y') }}</td>
                    <td class="date">{{ $p->fecha_devolucion_esperada ? $p->fecha_devolucion_esperada->format('d/m/Y') : '—' }}</td>
                    <td><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">No se registraron movimientos en este periodo.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="footer">
        <tr>
            <td>Centro de Gestión Administrativa — SENA</td>
            <td class="footer-right">Periodo: {{ now()->isoFormat('MMMM YYYY') }} | Total: {{ $prestamos->count() }} registros</td>
        </tr>
    </table>

</body>
</html>
