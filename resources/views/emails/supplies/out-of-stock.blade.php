<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif;">

    <h2 style="color:#dc2626;">
        🚨 Acción Requerida – Suministros Sin Stock
    </h2>

    <p>Estimados,</p>

    <p>
        Se informa que los siguientes suministros han agotado
        completamente su existencia en inventario.
    </p>

    <p>
        Se recomienda gestionar su adquisición a la brevedad
        para evitar interrupciones en la operación.
    </p>

    <table
        width="100%"
        cellpadding="8"
        cellspacing="0"
        border="1"
        style="border-collapse: collapse;"
    >
        <thead style="background-color:#fee2e2;">
            <tr>
                <th>Marca</th>
                <th>Modelo Impresora</th>
                <th>Suministro</th>
                <th>Stock</th>
            </tr>
        </thead>

        <tbody>
            @foreach($supplies as $supply)
                <tr>
                    <td>{{ $supply->brand }}</td>
                    <td>{{ $supply->printer_model }}</td>
                    <td>{{ $supply->supply_type }}</td>
                    <td>{{ $supply->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px;">
        Total de suministros sin stock:
        <strong>{{ $supplies->count() }}</strong>
    </p>

    <br>

    <p>
        Saludos cordiales.
    </p>

    <p>
        <strong>Gestor Múltiple</strong><br>
        Sistema de Gestión de Inventario
    </p>

</body>
</html>