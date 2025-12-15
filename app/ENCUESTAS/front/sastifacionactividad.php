<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción Actividades</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: #1f2937;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
            color: #1e40af;
        }

        .header p {
            font-size: 16px;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
            color: #4b5563;
        }

        .instrucciones {
            background: #eff6ff;
            border-radius: 15px;
            padding: 20px;
            color: #1e40af;
            text-align: center;
            margin-bottom: 30px;
            border: 2px solid #bfdbfe;
        }

        .instrucciones h3 {
            font-size: 18px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #1e40af;
        }

        .instrucciones p {
            font-size: 14px;
            color: #3b82f6;
        }

        .loading {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            font-size: 18px;
            color: #1e40af;
        }

        .pregunta-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.5s ease-out;
            transition: all 0.3s;
            position: relative;
        }

        .pregunta-card.bloqueada {
            opacity: 0.5;
            pointer-events: none;
            filter: grayscale(0.8);
        }

        .pregunta-card.bloqueada::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 20px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pregunta-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .pregunta-titulo {
            font-size: 20px;
            color: #1f2937;
            font-weight: 600;
            flex: 1;
        }

        .lock-icon {
            font-size: 24px;
            opacity: 0.5;
        }

        .opciones {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .opcion {
            flex: 1;
            min-width: 100px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .opcion:hover {
            transform: translateY(-5px);
        }

        .emoji-container {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px auto;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .opcion:hover .emoji-container {
            transform: scale(1.1);
        }

        .gif-emoji {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s;
        }

        .label {
            font-size: 12px;
            color: #4b5563;
            text-align: center;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .contador {
            font-size: 24px;
            color: #1e40af;
            font-weight: bold;
            text-align: center;
        }

        .contador.animado {
            animation: pulse 0.3s;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }

        .barra-progreso {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 8px;
        }

        .barra-fill {
            height: 100%;
            transition: width 0.5s ease-out;
            border-radius: 10px;
        }

        /* COLORES PARA LAS BARRAS */
        .muy-satisfecho .barra-fill {
            background: linear-gradient(90deg, #059162ff, #058c61ff);
        }

        .satisfecho .barra-fill {
            background: linear-gradient(90deg, #5eee82ff, #a4ff90ff);
        }

        .neutral .barra-fill {
            background: linear-gradient(90deg, #f5ed0bff, #d9cb06ff);
        }

        .insatisfecho .barra-fill {
            background: linear-gradient(90deg, #ff921eff, #dc9326ff);
        }

        .muy-iinsatisfecho .barra-fill {
            background: linear-gradient(90deg, #991b1b, #8f0707ff);
        }

        .porcentaje {
            font-size: 11px;
            color: #6b7280;
            text-align: center;
            margin-top: 5px;
        }

        .btn-restar {
            margin-top: 10px;
            padding: 6px 12px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-restar:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-restar:active {
            transform: translateY(0);
        }

        .total-votos {
            text-align: center;
            padding: 15px;
            background: #f3f4f6;
            border-radius: 10px;
            margin-top: 20px;
        }

        .total-votos span {
            font-size: 18px;
            color: #1e40af;
            font-weight: bold;
        }

        .acciones {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 15px 40px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #1e40af;
            border: 2px solid #3b82f6;
        }

        .btn-secondary:hover {
            background: #eff6ff;
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            max-width: 400px;
            animation: modalShow 0.3s ease-out;
        }

        @keyframes modalShow {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-content h2 {
            color: #22c55e;
            margin-bottom: 15px;
        }

        .modal-content button {
            margin-top: 20px;
            padding: 10px 30px;
            background: #1e40af;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }

        .modal-content button:hover {
            background: #1e3a8a;
            transform: translateY(-2px);
        }

        .error-message {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
        }

        .error-message h3 {
            color: #ef4444;
            margin-bottom: 15px;
        }

        .error-message button {
            margin-top: 20px;
            padding: 10px 30px;
            background: #1e40af;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .click-effect {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            animation: clickWave 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes clickWave {
            from {
                transform: scale(0);
                opacity: 1;
            }

            to {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .alerta-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            color: #1f2937;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 2000;
            font-weight: 500;
            opacity: 0;
            transform: translateX(400px);
            transition: all 0.3s ease-out;
            border-left: 4px solid #f59e0b;
        }

        .alerta-custom.show {
            opacity: 1;
            transform: translateX(0);
        }

        @media (max-width: 768px) {
            .opciones {
                flex-direction: column;
            }

            .opcion {
                min-width: 100%;
            }

            .header h1 {
                font-size: 28px;
            }

            .pregunta-titulo {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📊 Encuesta de Satisfacción Actividades</h1>
            <p>Cada clic cuenta como un voto. No es necesario una encuesta por persona, puedes votar varias veces en cada opción para acumular respuestas.</p>
        </div>

        <div class="instrucciones">
            <h3>💡 ¿Cómo funciona?</h3>
            <p>Haz clic en cualquier emoji para agregar un voto. Responde la primera pregunta para desbloquear la siguiente. ¡Observa cómo cambian los porcentajes en tiempo real!</p>
        </div>

        <div id="encuesta-container">
            <div class="loading">⏳ Cargando encuesta...</div>
        </div>

        <div class="acciones" id="acciones" style="display: none;">
            <button id="btn-enviar" class="btn-primary">📤 Enviar Encuesta</button>
            <button id="btn-reiniciar" class="btn-secondary">🔄 Reiniciar</button>
        </div>
    </div>

    <div id="modal-exito" class="modal">
        <div class="modal-content">
            <h2>✅ ¡Encuesta Enviada!</h2>
            <p>Gracias por tu participación. Los datos han sido guardados exitosamente.</p>
            <button onclick="location.reload()">Cerrar</button>
        </div>
    </div>

    <script src="../src/js/sastifaccionactividades.js"></script>
</body>

</html>