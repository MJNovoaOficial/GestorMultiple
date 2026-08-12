<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Direcciones IP</title>

    <style>
        @page {
            size: letter landscape;
            margin: 35px 30px 45px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #1f2937;
            margin: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Encabezado
        |--------------------------------------------------------------------------
        */

        .header {
            width: 100%;
            margin-bottom: 8px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-left {
            width: 65%;
            vertical-align: middle;
        }

        .header-right {
            width: 35%;
            text-align: right;
            vertical-align: middle;
        }

        .title {
            font-size: 19px;
            font-weight: bold;
            color: #111827;
            margin: 0 0 5px 0;
        }

        .subtitle {
            font-size: 10px;
            color: #4b5563;
            margin: 2px 0;
        }

        .logo {
            width: 170px;
            max-height: 55px;
            object-fit: contain;
        }

        /*
        |--------------------------------------------------------------------------
        | Línea corporativa
        |--------------------------------------------------------------------------
        */

        .corporate-line {
            width: 100%;
            height: 5px;
            background-color: #e31e2f;
            margin: 8px 0 14px 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Información de subnet
        |--------------------------------------------------------------------------
        */

        .subnet-info {
            width: 100%;
            margin-bottom: 9px;
        }

        .subnet-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .subnet-label {
            font-size: 9px;
            color: #6b7280;
        }

        .subnet-value {
            font-size: 11px;
            font-weight: bold;
            color: #111827;
        }

        .subnet-date {
            text-align: right;
            vertical-align: bottom;
            font-size: 8px;
            color: #6b7280;
        }

        /*
        |--------------------------------------------------------------------------
        | Tabla
        |--------------------------------------------------------------------------
        */

        .ip-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .ip-table thead {
            display: table-header-group;
        }

        .ip-table th {
            background-color: #7394c9;
            color: #ffffff;
            font-size: 8.5px;
            font-weight: bold;
            text-align: center;
            padding: 6px 5px;
            border: 1px solid #5f7fae;
            vertical-align: middle;
        }

        .ip-table td {
            padding: 3px 5px;
            border: 1px solid #d1d5db;
            text-align: center;
            vertical-align: middle;
            height: 17px;
            word-wrap: break-word;
        }

        .ip-table tbody tr:nth-child(even) {
            background-color: #f5f7fa;
        }

        .ip-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .status {
            display: inline-block;
            padding: 3px 9px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            white-space: nowrap;
        }

        .status-available {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-occupied {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-default {
            background-color: #e5e7eb;
            color: #374151;
        }
        /*
        |--------------------------------------------------------------------------
        | Anchos de columnas
        |--------------------------------------------------------------------------
        */

        .col-ip {
            width: 13%;
        }

        .col-status {
            width: 13%;
        }

        .col-user {
            width: 20%;
        }

        .col-device {
            width: 16%;
        }

        .col-branch {
            width: 16%;
        }

        .col-department {
            width: 22%;
        }

        /*
        |--------------------------------------------------------------------------
        | Separación entre subnets
        |--------------------------------------------------------------------------
        */

        .subnet-section {
            page-break-before: always;
        }

        .subnet-section:first-child {
            page-break-before: auto;
        }

        /*
        |--------------------------------------------------------------------------
        | Pie de página
        |--------------------------------------------------------------------------
        */

        .footer {
            position: fixed;
            bottom: -28px;
            left: 0;
            right: 0;
            height: 20px;
            border-top: 1px solid #d1d5db;
            padding-top: 5px;
            font-size: 7.5px;
            color: #6b7280;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }

        .page-number::after {
            content: counter(page);
        }
    </style>
</head>

<body>

    @foreach($sections as $section)

        <div class="subnet-section">

            {{-- ==========================================================
                 ENCABEZADO
            =========================================================== --}}

            <div class="header">

                <table class="header-table">

                    <tr>

                        <td class="header-left">

                            <div class="title">
                                Direcciones IP
                            </div>

                            <div class="subtitle">
                                MultiGestor
                            </div>

                        </td>

                        <td class="header-right">

                            <img
                                src="{{ public_path('images/dimak.jpg') }}"
                                class="logo"
                                alt="Dimak">

                        </td>

                    </tr>

                </table>

            </div>


            <div class="corporate-line"></div>


            {{-- ==========================================================
                 INFORMACIÓN DE LA SUBNET
            =========================================================== --}}

            <div class="subnet-info">

                <table class="subnet-info-table">

                    <tr>

                        <td>

                            <div class="subnet-label">
                                Sucursal
                            </div>

                            <div class="subnet-value">
                                {{ $section['branch'] ?: 'Sin sucursal' }}
                            </div>

                        </td>

                        <td>

                            <div class="subnet-label">
                                Red
                            </div>

                            <div class="subnet-value">
                                {{ $section['subnet'] }}
                            </div>

                        </td>

                        <td class="subnet-date">

                            Generado:
                            {{ now()->format('d-m-Y H:i') }}

                        </td>

                    </tr>

                </table>

            </div>


            {{-- ==========================================================
                 TABLA DE IPs
            =========================================================== --}}

            <table class="ip-table">

                <thead>

                    <tr>

                        @foreach($columns as $column)

                            @switch($column)

                                @case('ip')
                                    <th class="col-ip">
                                        IP
                                    </th>
                                    @break

                                @case('status')
                                    <th class="col-status">
                                        Estado
                                    </th>
                                    @break

                                @case('user')
                                    <th class="col-user">
                                        Usuario Responsable
                                    </th>
                                    @break

                                @case('device')
                                    <th class="col-device">
                                        Dispositivo
                                    </th>
                                    @break

                                @case('department')
                                    <th class="col-department">
                                        Departamento
                                    </th>
                                    @break

                            @endswitch

                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @foreach($section['rows'] as $row)

                        <tr>

                            @foreach($columns as $column)

                                <td>

                                    @if($column === 'status')

                                        @php
                                            $status = strtolower(trim($row[$column] ?? ''));
                                        @endphp

                                        @if($status === 'disponible')

                                            <span class="status status-available">
                                                {{ $row[$column] }}
                                            </span>

                                        @elseif($status === 'ocupado')

                                            <span class="status status-occupied">
                                                {{ $row[$column] }}
                                            </span>

                                        @else

                                            <span class="status status-default">
                                                {{ $row[$column] ?? '' }}
                                            </span>

                                        @endif

                                    @else

                                        {{ $row[$column] ?? '' }}

                                    @endif

                                </td>

                            @endforeach

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endforeach


    {{-- ================================================================
         PIE DE PÁGINA
    ================================================================= --}}

    <div class="footer">

        <span class="footer-left">
            MultiGestor · Inventario de Direcciones IP
        </span>

        <span class="footer-right">
            Página <span class="page-number"></span>
        </span>

    </div>

</body>

</html>