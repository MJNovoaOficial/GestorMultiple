<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body style="font-family: Arial, sans-serif;">

        <h2 style="color:#d97706;">
            ⚠️ Alerta de Inventario – Suministros con Stock Crítico
        </h2>

        <p>Estimados,</p>

        <p>
            Junto con saludar, se informa que el sistema
            <strong>Gestor de Suministros TI</strong>
            ha detectado suministros cuyo stock actual 
            se encuentra por debajo del nivel mínimo definido.
        </p>

        <p>
            Se recomienda evaluar su reposición para asegurar
            la continuidad operacional de los equipos asociados.
        </p>

        <table
            width="100%"
            cellpadding="8"
            cellspacing="0"
            border="1"
            style="border-collapse: collapse;"
        >
            <thead style="background-color:#f3f4f6;">
                <tr>
                    <th>Marca</th>
                    <th>Modelo Impresora</th>
                    <th>Suministro</th>
                    <th>Stock Actual</th>
                    <th>Stock Mínimo</th>
                </tr>
            </thead>

            <tbody>
                @foreach($supplies as $supply)
                    <tr>
                        <td>{{ $supply->brand }}</td>
                        <td>{{ $supply->printer_model }}</td>
                        <td>{{ $supply->supply_type }}</td>
                        <td>{{ $supply->quantity }}</td>
                        <td>{{ $supply->minimum_stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top:20px;">
            Total de suministros críticos:
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