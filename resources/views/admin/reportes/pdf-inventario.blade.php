<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Inventario - SENA</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9px;
            color: #1e293b;
            margin: 20px;
        }

        /* Header */
        .header-table { width: 100%; margin-bottom: 15px; }
        .header-title { font-size: 17px; font-weight: bold; color: #00324D; }
        .header-sub   { font-size: 8px; color: #64748b; text-transform: uppercase; margin-top: 3px; }
        .header-sena  { font-size: 14px; font-weight: bold; color: #39A900; text-align: right; }
        .header-date  { font-size: 8px; color: #94a3b8; text-align: right; }
        .divider      { border-top: 2.5px solid #39A900; margin-bottom: 12px; }

        /* Stats */
        .stats-table { width: 100%; margin-bottom: 14px; border-collapse: collapse; }
        .stat-cell {
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            text-align: center;
            padding: 6px 8px;
            width: 20%;
        }
        .stat-num  { font-size: 15px; font-weight: bold; color: #00324D; display: block; }
        .stat-lbl  { font-size: 7px; color: #94a3b8; text-transform: uppercase; display: block; }

        /* Table */
        .data-table { width: 100%; border-spacing: 0; }
        .data-table thead tr { background-color: #00324D; color: #ffffff; }
        .data-table thead th { padding: 6px 8px; text-align: left; font-size: 8px; text-transform: uppercase; border-bottom: 2px solid #0f172a; }
        .data-table tbody tr { page-break-inside: avoid; }
        .data-table tbody tr.even { background-color: #f8fafc; }
        .data-table tbody tr.odd  { background-color: #ffffff; }
        .data-table tbody td { padding: 5px 8px; border-bottom: 1px solid #f1f5f9; }

        .code { color: #39A900; font-weight: bold; font-size: 8px; }
        .name { font-weight: bold; color: #00324D; }
        .cat  { color: #64748b; }
        .desc { color: #94a3b8; font-size: 7.5px; }
        .num  { color: #94a3b8; font-size: 7.5px; }

        /* Badges */
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 7.5px; font-weight: bold; text-transform: uppercase; }
        .b-disponible    { background: #dcfce7; color: #166534; }
        .b-prestado      { background: #dbeafe; color: #1e40af; }
        .b-mantenimiento { background: #fef9c3; color: #713f12; }
        .b-baja          { background: #fee2e2; color: #991b1b; }

        /* Footer */
        .footer { margin-top: 14px; border-top: 1px solid #e2e8f0; padding-top: 6px; font-size: 7.5px; color: #94a3b8; }
        .footer-right { text-align: right; }
    </style>
</head>
<body>

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td>
                <div class="header-title">Reporte de Inventario</div>
                <div class="header-sub">Control de Elementos — Sistema de Préstamos SENA</div>
            </td>
            <td>
                <div class="header-sena">SENA</div>
                <div class="header-date">Generado el {{ now()->format('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>
    <div class="divider"></div>

    {{-- Stats --}}
    @php
        $total       = $elementos->count();
        $disponibles = $elementos->where('estado', 'Disponible')->count();
        $prestados   = $elementos->where('estado', 'Prestado')->count();
        $mant        = $elementos->where('estado', 'En Mantenimiento')->count();
        $baja        = $elementos->where('estado', 'Dado de Baja')->count();
    @endphp
    <table class="stats-table">
        <tr>
            <td class="stat-cell">
                <span class="stat-num">{{ $total }}</span>
                <span class="stat-lbl">Total</span>
            </td>
            <td class="stat-cell">
                <span class="stat-num" style="color:#166534;">{{ $disponibles }}</span>
                <span class="stat-lbl">Disponibles</span>
            </td>
            <td class="stat-cell">
                <span class="stat-num" style="color:#1e40af;">{{ $prestados }}</span>
                <span class="stat-lbl">Prestados</span>
            </td>
            <td class="stat-cell">
                <span class="stat-num" style="color:#713f12;">{{ $mant }}</span>
                <span class="stat-lbl">Mantenimiento</span>
            </td>
            <td class="stat-cell">
                <span class="stat-num" style="color:#991b1b;">{{ $baja }}</span>
                <span class="stat-lbl">Dado de Baja</span>
            </td>
        </tr>
    </table>

    {{-- Data Table --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:3%">#</th>
                <th style="width:14%">Código SENA</th>
                <th style="width:22%">Nombre</th>
                <th style="width:16%">Categoría</th>
                <th style="width:30%">Descripción</th>
                <th style="width:15%">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($elementos as $i => $e)
                @php
                    $rowClass = ($i % 2 === 0) ? 'even' : 'odd';
                    $estadoMap = [
                        'Disponible'       => 'b-disponible',
                        'Prestado'         => 'b-prestado',
                        'En Mantenimiento' => 'b-mantenimiento',
                        'Dado de Baja'     => 'b-baja',
                    ];
                    $badgeClass = $estadoMap[$e->estado] ?? 'b-disponible';
                @endphp
                <tr class="{{ $rowClass }}">
                    <td class="num">{{ $i + 1 }}</td>
                    <td class="code">{{ $e->codigo_sena ?? '—' }}</td>
                    <td class="name">{{ $e->nombre }}</td>
                    <td class="cat">{{ $e->categoria->nombre ?? '—' }}</td>
                    <td class="desc">{{ \Str::limit($e->descripcion ?? '—', 60) }}</td>
                    <td><span class="badge {{ $badgeClass }}">{{ $e->estado }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer --}}
    <table class="footer" style="width:100%">
        <tr>
            <td>Sistema de Préstamos — SENA</td>
            <td class="footer-right">Total: {{ $total }} elemento(s) | Documento oficial de auditoría</td>
        </tr>
    </table>

</body>
</html>
