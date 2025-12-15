<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas - Control Biológico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #16a34a;
            --secondary-green: #059669;
            --light-green: #dcfce7;
            --dark-green: #14532d;
            --success: #22c55e;
            --warning: #eab308;
            --danger: #ef4444;
            --info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 50%, #6ee7b7 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.1;
        }

        body::before {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, var(--primary-green) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            animation: float 20s ease-in-out infinite;
        }

        body::after {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, var(--secondary-green) 0%, transparent 70%);
            bottom: -150px;
            left: -150px;
            animation: float 15s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }

            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        .main-container {
            max-width: 1600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .main-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            border-radius: 24px;
            padding: 40px 50px;
            margin-bottom: 35px;
            box-shadow: 0 15px 50px rgba(22, 163, 74, 0.25), 0 5px 15px rgba(22, 163, 74, 0.1);
            animation: slideDown 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .main-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main-header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 18px;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .main-header h1 i {
            animation: bounceRotate 3s ease-in-out infinite;
        }

        @keyframes bounceRotate {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-8px) rotate(10deg);
            }
        }

        .main-header p {
            font-size: 1.15rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .filtros-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 35px 40px;
            margin-bottom: 35px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
            border: 1px solid rgba(22, 163, 74, 0.1);
            position: relative;
            overflow: hidden;
        }

        .filtros-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--secondary-green), var(--success));
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .filtros-title {
            color: var(--primary-green);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filtros-title i {
            animation: filterPulse 2s ease-in-out infinite;
        }

        @keyframes filterPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .form-label {
            color: var(--dark-green);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label i {
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .form-control,
        .form-select {
            border: 2px solid #d1fae5;
            border-radius: 14px;
            padding: 13px 18px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            font-size: 1rem;
            background: white;
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #a7f3d0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.1);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 5px rgba(22, 163, 74, 0.12);
            transform: translateY(-2px);
        }

        .btn-custom {
            padding: 14px 32px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-custom:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-custom i {
            position: relative;
            z-index: 1;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(22, 163, 74, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(22, 163, 74, 0.4);
        }

        .btn-primary-custom:active {
            transform: translateY(-1px);
        }

        .btn-secondary-custom {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
        }

        .btn-secondary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.4);
        }

        .btn-success-custom {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
        }

        .btn-success-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(34, 197, 94, 0.4);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 28px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            opacity: 0.05;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .stat-card:hover::before {
            width: 10px;
        }

        .stat-card:hover::after {
            width: 150px;
            height: 150px;
            opacity: 0.08;
        }

        .stat-card.green::before {
            background: linear-gradient(180deg, var(--primary-green), var(--success));
        }

        .stat-card.green::after {
            background: var(--primary-green);
        }

        .stat-card.blue::before {
            background: linear-gradient(180deg, var(--info), #2563eb);
        }

        .stat-card.blue::after {
            background: var(--info);
        }

        .stat-card.yellow::before {
            background: linear-gradient(180deg, var(--warning), #f59e0b);
        }

        .stat-card.yellow::after {
            background: var(--warning);
        }

        .stat-card.red::before {
            background: linear-gradient(180deg, var(--danger), #dc2626);
        }

        .stat-card.red::after {
            background: var(--danger);
        }

        .stat-card.purple::before {
            background: linear-gradient(180deg, #a855f7, #9333ea);
        }

        .stat-card.purple::after {
            background: #a855f7;
        }

        .stat-card.teal::before {
            background: linear-gradient(180deg, #14b8a6, #0d9488);
        }

        .stat-card.teal::after {
            background: #14b8a6;
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 22px;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 1;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.15) rotate(5deg);
        }

        .stat-card.green .stat-icon {
            background: linear-gradient(135deg, rgba(22, 163, 74, 0.15), rgba(34, 197, 94, 0.15));
            color: var(--primary-green);
            box-shadow: 0 4px 15px rgba(22, 163, 74, 0.2);
        }

        .stat-card.blue .stat-icon {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.15));
            color: var(--info);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        }

        .stat-card.yellow .stat-icon {
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.15), rgba(245, 158, 11, 0.15));
            color: var(--warning);
            box-shadow: 0 4px 15px rgba(234, 179, 8, 0.2);
        }

        .stat-card.red .stat-icon {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(220, 38, 38, 0.15));
            color: var(--danger);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }

        .stat-card.purple .stat-icon {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.15), rgba(147, 51, 234, 0.15));
            color: #a855f7;
            box-shadow: 0 4px 15px rgba(168, 85, 247, 0.2);
        }

        .stat-card.teal .stat-icon {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.15), rgba(13, 148, 136, 0.15));
            color: #14b8a6;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.2);
        }

        .stat-title {
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            position: relative;
            z-index: 1;
        }

        .stat-value {
            color: #1e293b;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
            position: relative;
            z-index: 1;
            animation: countUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(550px, 1fr));
            gap: 35px;
            margin-bottom: 35px;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(22, 163, 74, 0.1);
            position: relative;
            overflow: hidden;
        }

        .chart-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-green), var(--secondary-green));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .chart-card:hover::before {
            transform: scaleX(1);
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.12), 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .chart-title {
            color: var(--dark-green);
            font-weight: 700;
            font-size: 1.35rem;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(22, 163, 74, 0.1);
        }

        .chart-title i {
            color: var(--primary-green);
            font-size: 1.6rem;
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        canvas {
            max-height: 350px;
            animation: chartAppear 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
        }

        @keyframes chartAppear {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .spinner {
            border: 6px solid #d1fae5;
            border-top: 6px solid var(--primary-green);
            border-right: 6px solid var(--secondary-green);
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
            position: relative;
        }

        .spinner::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 4px solid transparent;
            border-top: 4px solid var(--success);
            border-radius: 50%;
            animation: spin 0.7s linear infinite reverse;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            margin-top: 25px;
            color: var(--primary-green);
            font-size: 1.4rem;
            font-weight: 700;
            animation: loadingPulse 1.5s ease-in-out infinite;
        }

        @keyframes loadingPulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .no-data {
            text-align: center;
            padding: 80px 40px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .no-data i {
            font-size: 6rem;
            color: #cbd5e1;
            margin-bottom: 25px;
            animation: emptyBounce 2s ease-in-out infinite;
        }

        @keyframes emptyBounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .no-data h3 {
            color: #64748b;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .no-data p {
            color: #94a3b8;
            font-size: 1.15rem;
        }

        .stats-grid .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stats-grid .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stats-grid .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stats-grid .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stats-grid .stat-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .stats-grid .stat-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        .charts-container .chart-card:nth-child(1) {
            animation-delay: 0.2s;
        }

        .charts-container .chart-card:nth-child(2) {
            animation-delay: 0.4s;
        }

        .charts-container .chart-card:nth-child(3) {
            animation-delay: 0.6s;
        }

        .charts-container .chart-card:nth-child(4) {
            animation-delay: 0.8s;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .main-header {
                padding: 30px 25px;
                border-radius: 20px;
            }

            .main-header h1 {
                font-size: 2rem;
                gap: 12px;
            }

            .main-header p {
                font-size: 1rem;
            }

            .filtros-card {
                padding: 25px 20px;
                border-radius: 20px;
            }

            .filtros-title {
                font-size: 1.3rem;
            }

            .charts-container {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-value {
                font-size: 2.5rem;
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                font-size: 1.6rem;
            }

            .btn-custom {
                padding: 12px 24px;
                font-size: 0.95rem;
                width: 100%;
                justify-content: center;
            }

            .chart-card {
                padding: 25px 20px;
                border-radius: 20px;
            }

            .no-data {
                padding: 60px 25px;
            }

            .no-data i {
                font-size: 4.5rem;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>

<body>
    <div class="main-container">
        <div class="main-header">
            <h1><i class="bi bi-graph-up-arrow"></i>Dashboard de Estadísticas</h1>
            <p>Análisis y métricas de actividades de control biológico</p>
        </div>
        <div class="filtros-card">
            <h2 class="filtros-title"><i class="bi bi-funnel-fill"></i>Filtros de Búsqueda</h2>
            <div class="row g-3 mb-4">
                <div class="col-md-4 col-lg-2">
                    <label class="form-label"><i class="bi bi-calendar-event"></i> Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio">
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label"><i class="bi bi-calendar-check"></i> Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha_fin">
                </div>
                <div class="col-md-4 col-lg-3">
                    <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Sitio</label>
                    <select class="form-select" id="sitio">
                        <option value="">Todos los sitios</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label class="form-label"><i class="bi bi-clipboard-check"></i> Tipo de Actividad</label>
                    <select class="form-select" id="tipo_actividad">
                        <option value="">Todas las actividades</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-2">
                    <label class="form-label"><i class="bi bi-person-fill"></i> Usuario</label>
                    <select class="form-select" id="usuario">
                        <option value="">Todos los usuarios</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-3 justify-content-end flex-wrap">
                <button class="btn-custom btn-primary-custom" onclick="cargarEstadisticas()">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <button class="btn-custom btn-secondary-custom" onclick="exportarPDF()">
                    <i class="bi bi-file-pdf"></i> Exportar PDF
                </button>
                <button class="btn-custom btn-success-custom" onclick="exportarExcel()">
                    <i class="bi bi-file-earmark-excel"></i> Exportar Excel
                </button>
            </div>
        </div>
        <div id="loading" class="loading-overlay" style="display: none;">
            <div class="spinner"></div>
            <p class="loading-text">Cargando estadísticas...</p>
        </div>
        <div id="cards-resumen" class="stats-grid"></div>
        <div id="graficas" class="charts-container"></div>
        <div id="no-data" class="no-data" style="display: none;">
            <i class="bi bi-inbox"></i>
            <h3>No hay datos disponibles</h3>
            <p>Intenta ajustar los filtros para obtener resultados</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../../src/js/estadisticas.js"></script>
</body>

</html>