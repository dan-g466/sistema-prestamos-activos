<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Préstamos del Mes - SENA</title>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; padding: 40px; }
        .container { background: white; padding: 40px; max-width: 1000px; margin: auto; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #39A900; padding-bottom: 15px; margin-bottom: 30px; }
        h1 { margin: 0; font-size: 24px; color: #1f2937; }
        .sena-label { color: #00324D; font-weight: bold; font-size: 14px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f9fafb; color: #4b5563; text-transform: uppercase; font-size: 11px; padding: 12px 15px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        td { padding: 12px 15px; font-size: 13px; border-bottom: 1px solid #f3f4f6; color: #374151; }
        .item-name { color: #00324D; font-family: monospace; font-size: 11px; }
        .status { font-weight: bold; font-size: 11px; text-transform: uppercase; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; color: #9ca3af; }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body class="bg-white p-10 font-sans text-sm">
    <div id="report-content" class="container">
        <div class="header">
            <div>
                <h1>Préstamos del Mes</h1>
                <div style="color: #6b7280; font-size: 11px; margin-top: 5px;">{{ now()->isoFormat('MMMM YYYY') }} — Generado el {{ now()->format('d/m/Y H:i') }}</div>
            </div>
            <div class="sena-label">Sistema Préstamos SENA</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Aprendiz</th>
                    <th>Elemento</th>
                    <th>F. Solicitud</th>
                    <th>F. Devolución</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamos as $p)
                    <tr>
                        <td style="font-weight: 600;">{{ $p->user->name }}</td>
                        <td class="item-name">{{ $p->elemento->nombre }}</td>
                        <td>{{ $p->fecha_solicitud->format('d/m/Y') }}</td>
                        <td>{{ $p->fecha_devolucion_esperada->format('d/m/Y') }}</td>
                        <td class="status">{{ $p->estado }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align: center; padding: 40px; color: #9ca3af;">Sin préstamos este mes.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="footer">Total: {{ $prestamos->count() }} préstamo(s)</div>
    </div>

    <script>
        window.onload = () => {
            setTimeout(() => {
                const element = document.getElementById('report-content');
                const opt = {
                    margin: 0.5,
                    filename: 'reporte-prestamos-del-mes.pdf',
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: { 
                        scale: 2, 
                        useCORS: true,
                        logging: true,
                        backgroundColor: '#ffffff'
                    },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
                };

                html2pdf().set(opt).from(element).save().then(() => {
                    setTimeout(() => window.close(), 1000);
                });
            }, 1000);
        };
    </script>
</body>
</html>
