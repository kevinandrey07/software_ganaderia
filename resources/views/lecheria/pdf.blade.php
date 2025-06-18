<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Producción de Leche</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #f2f2f2; }
        h1 { text-align: center; margin-bottom: 10px; }
        p { margin: 0; padding: 0; }
    </style>
</head>
<body>
    <h1>Reporte Producción de Leche</h1>
    <p><strong>Generado el:</strong> {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Vaca</th>
                <th>Fecha</th>
                <th>Litros</th>
                <th>Notas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($producciones as $prod)
            <tr>
                <td>{{ $prod->animal->code }} - {{ $prod->animal->name }}</td>
                <td>{{ $prod->date }}</td>
                <td>{{ $prod->liters }}</td>
                <td>{{ $prod->notes }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No hay registros para los filtros seleccionados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
