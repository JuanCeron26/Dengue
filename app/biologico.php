<?php
session_start();
$permiso = $_SESSION["permiso"] ?? '1';

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Módulos de Control Biológico</title>
  <link rel="stylesheet" href="../src/css/styles.css">
  <style>
    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-8px);
      }
    }

    @keyframes shimmer {
      0% {
        background-position: -200% center;
      }

      100% {
        background-position: 200% center;
      }
    }

    @keyframes ripple {
      0% {
        transform: scale(0);
        opacity: 1;
      }

      100% {
        transform: scale(4);
        opacity: 0;
      }
    }

    @keyframes rotate {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    @keyframes pulse-shadow {

      0%,
      100% {
        box-shadow: 0 10px 30px rgba(74, 124, 41, 0.15);
      }

      50% {
        box-shadow: 0 15px 45px rgba(74, 124, 41, 0.3);
      }
    }

    .animate-fadeInDown {
      animation: fadeInDown 0.8s ease;
    }

    .animate-fadeInUp {
      animation: fadeInUp 0.8s ease 0.2s backwards;
    }

    .modulo-bg-campo {
      background: linear-gradient(145deg, rgba(245, 255, 250, 0.98), rgba(255, 255, 255, 0.95));
      box-shadow: 0 10px 30px rgba(74, 124, 41, 0.12);
      border: 1.5px solid rgba(111, 179, 63, 0.2);
      position: relative;
      overflow: hidden;
    }

    .modulo-bg-campo::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(111, 179, 63, 0.1), transparent);
      transition: left 0.7s ease;
    }

    .modulo-bg-campo:hover::before {
      left: 100%;
    }

    .modulo-bg-campo::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 150%;
      height: 150%;
      background: radial-gradient(circle, rgba(111, 179, 63, 0.06) 0%, transparent 70%);
      opacity: 0;
      transition: opacity 0.5s ease;
      animation: rotate 20s linear infinite;
    }

    .modulo-bg-campo:hover::after {
      opacity: 1;
    }

    .modulo-bg-zoocriadero {
      background: linear-gradient(145deg, rgba(240, 248, 255, 0.98), rgba(255, 255, 255, 0.95));
      box-shadow: 0 10px 30px rgba(0, 119, 200, 0.12);
      border: 1.5px solid rgba(100, 181, 246, 0.2);
      position: relative;
      overflow: hidden;
    }

    .modulo-bg-zoocriadero::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(100, 181, 246, 0.1), transparent);
      transition: left 0.7s ease;
    }

    .modulo-bg-zoocriadero:hover::before {
      left: 100%;
    }

    .modulo-bg-zoocriadero::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 150%;
      height: 150%;
      background: radial-gradient(circle, rgba(100, 181, 246, 0.06) 0%, transparent 70%);
      opacity: 0;
      transition: opacity 0.5s ease;
      animation: rotate 20s linear infinite;
    }

    .modulo-bg-zoocriadero:hover::after {
      opacity: 1;
    }

    .btn-campo {
      background: linear-gradient(135deg, #6fb33f 0%, #4a7c29 100%);
      background-size: 200% 200%;
      position: relative;
      overflow: hidden;
      transition: all 0.4s ease;
    }

    .btn-campo::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.4);
      transform: translate(-50%, -50%);
      transition: width 0.5s ease, height 0.5s ease;
    }

    .btn-campo:hover::before {
      width: 300px;
      height: 300px;
    }

    .btn-campo:hover {
      background-position: right center;
      transform: translateY(-2px);
    }

    .btn-zoocriadero {
      background: linear-gradient(135deg, #64b5f6 0%, #0077c8 100%);
      background-size: 200% 200%;
      position: relative;
      overflow: hidden;
      transition: all 0.4s ease;
    }

    .btn-zoocriadero::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.4);
      transform: translate(-50%, -50%);
      transition: width 0.5s ease, height 0.5s ease;
    }

    .btn-zoocriadero:hover::before {
      width: 300px;
      height: 300px;
    }

    .btn-zoocriadero:hover {
      background-position: right center;
      transform: translateY(-2px);
    }

    .icon-container {
      width: 85px;
      height: 85px;
      padding: 6px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-sizing: content-box;
      background-color: white;
      position: relative;
      transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .icon-container::after {
      content: '';
      position: absolute;
      inset: -8px;
      border-radius: 50%;
      opacity: 0;
      transition: opacity 0.4s ease;
      z-index: -1;
    }

    .icon-container:hover {
      transform: scale(1.2) rotate(10deg);
      animation: float 2s ease-in-out infinite;
    }

    .icon-container.campo {
      border: 5px solid transparent;
      background: linear-gradient(white, white) padding-box,
        linear-gradient(135deg, #6fb33f, #4a7c29) border-box;
      box-shadow: 0 6px 20px rgba(74, 124, 41, 0.2);
    }

    .icon-container.campo::after {
      background: radial-gradient(circle, rgba(111, 179, 63, 0.4) 0%, transparent 70%);
    }

    .icon-container.campo:hover {
      box-shadow: 0 10px 35px rgba(74, 124, 41, 0.35);
    }

    .icon-container.campo:hover::after {
      opacity: 1;
    }

    .icon-container.zoocriadero {
      border: 5px solid transparent;
      background: linear-gradient(white, white) padding-box,
        linear-gradient(135deg, #64b5f6, #0077c8) border-box;
      box-shadow: 0 6px 20px rgba(0, 119, 200, 0.2);
    }

    .icon-container.zoocriadero::after {
      background: radial-gradient(circle, rgba(100, 181, 246, 0.4) 0%, transparent 70%);
    }

    .icon-container.zoocriadero:hover {
      box-shadow: 0 10px 35px rgba(0, 119, 200, 0.35);
    }

    .icon-container.zoocriadero:hover::after {
      opacity: 1;
    }

    .icon-symbol {
      font-size: 48px;
      line-height: 1;
      display: inline-block;
      filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.1));
      transition: all 0.3s ease;
    }

    .icon-container:hover .icon-symbol {
      transform: scale(1.15);
      filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.2));
    }

    .decorative-line {
      width: 60px;
      height: 3px;
      margin: 0 auto;
      border-radius: 2px;
      transition: all 0.4s ease;
    }

    .group:hover .decorative-line {
      width: 100px;
    }

    .decorative-line.campo {
      background: linear-gradient(90deg, #6fb33f, #4a7c29);
      box-shadow: 0 2px 8px rgba(74, 124, 41, 0.3);
    }

    .decorative-line.zoocriadero {
      background: linear-gradient(90deg, #64b5f6, #0077c8);
      box-shadow: 0 2px 8px rgba(0, 119, 200, 0.3);
    }

    @keyframes sparkle {

      0%,
      100% {
        opacity: 0;
        transform: scale(0);
      }

      50% {
        opacity: 1;
        transform: scale(1);
      }
    }

    .sparkle {
      position: absolute;
      width: 4px;
      height: 4px;
      border-radius: 50%;
      pointer-events: none;
      animation: sparkle 2s ease-in-out infinite;
    }

    .sparkle-campo {
      background: radial-gradient(circle, #6fb33f, transparent);
    }

    .sparkle-zoocriadero {
      background: radial-gradient(circle, #64b5f6, transparent);
    }
  </style>
</head>

<body class="min-h-screen p-6 md:p-10 flex flex-col items-center justify-center text-gris-texto font-['Segoe_UI',_Tahoma,_Geneva,_Verdana,_sans-serif] bg-white">

  <h1 class="text-center mb-16 text-4xl md:text-6xl font-black text-gris-texto tracking-wide drop-shadow-lg animate-fadeInDown relative">
    Control Biológico
    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-verde-claro via-azul-claro to-verde-claro rounded-full opacity-50"></div>
  </h1>
  <?php if ($permiso == '4') { ?>
    <div class="w-full flex flex-col justify-center">
      <a href="principal.php" class="group flex flex-col items-center mb-4">
        <img src="../src/icons/icono_exit.png" alt="" class="h-7 w-7
                text-2xl text-red-600 transition-all duration-300 
                group-hover:scale-110 group-hover:rotate-6">

        <span class="mt-2 text-xs opacity-0 translate-y-2 text-center
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
          Volver
        </span>
      </a>
    </div>
  <?php } ?>
  <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 animate-fadeInUp">

    <!-- MÓDULO CAMPO -->
    <div class="group modulo modulo-bg-campo rounded-2xl p-8 md:p-10 transition-all duration-500 ease-out hover:shadow-[0_20px_60px_rgba(74,124,41,0.2)] hover:-translate-y-2 hover:scale-[1.03] cursor-pointer backdrop-blur-sm">

      <!-- Sparkles decorativos -->
      <div class="sparkle sparkle-campo" style="top: 15%; left: 20%; animation-delay: 0s;"></div>
      <div class="sparkle sparkle-campo" style="top: 70%; right: 25%; animation-delay: 1s;"></div>
      <div class="sparkle sparkle-campo" style="bottom: 20%; left: 30%; animation-delay: 2s;"></div>

      <div class="text-center relative z-10">
        <div class="icon-container campo mx-auto mb-6">
          <span class="icon-symbol" style="color: #4a7c29;">
            🌱
          </span>
        </div>

        <h2 class="text-3xl font-extrabold text-gris-texto mb-2 tracking-wide">
          Campo
        </h2>

        <div class="decorative-line campo mb-6"></div>

        <p class="text-base leading-relaxed mt-4 mb-8 opacity-80 group-hover:opacity-100 transition-opacity duration-300 px-2">
          Registro y monitoreo de controladores biológicos en terreno.
        </p>

        <a href="./trabajo_campo_kelly/views/dashboard.php" class="relative inline-block px-10 py-3 text-white rounded-full transition-all duration-400 text-sm font-bold uppercase tracking-wider
              btn-campo shadow-md hover:shadow-xl border-2 border-white/30 z-10">
          <span class="relative z-10">Ingresar</span>
        </a>
      </div>
    </div>

    <!-- MÓDULO ZOOCRIADERO -->
    <div class="group modulo modulo-bg-zoocriadero rounded-2xl p-8 md:p-10 transition-all duration-500 ease-out hover:shadow-[0_20px_60px_rgba(0,119,200,0.2)] hover:-translate-y-2 hover:scale-[1.03] cursor-pointer backdrop-blur-sm">

      <!-- Sparkles decorativos -->
      <div class="sparkle sparkle-zoocriadero" style="top: 20%; right: 20%; animation-delay: 0.5s;"></div>
      <div class="sparkle sparkle-zoocriadero" style="top: 65%; left: 25%; animation-delay: 1.5s;"></div>
      <div class="sparkle sparkle-zoocriadero" style="bottom: 25%; right: 30%; animation-delay: 2.5s;"></div>

      <div class="text-center relative z-10">
        <div class="icon-container zoocriadero mx-auto mb-6">
          <span class="icon-symbol" style="color: #0077c8;">
            🐟
          </span>
        </div>

        <h2 class="text-3xl font-extrabold text-gris-texto mb-2 tracking-wide">
          Zoocriadero
        </h2>

        <div class="decorative-line zoocriadero mb-6"></div>

        <p class="text-base leading-relaxed mt-4 mb-8 opacity-80 group-hover:opacity-100 transition-opacity duration-300 px-2">
          Gestión de cría y producción de peces guppies controladores.
        </p>

        <a href="./zoocriadero/views/dashboard.php" class="relative inline-block px-10 py-3 text-white rounded-full transition-all duration-400 text-sm font-bold uppercase tracking-wider
              btn-zoocriadero shadow-md hover:shadow-xl border-2 border-white/30 z-10">
          <span class="relative z-10">Ingresar</span>
        </a>
      </div>
    </div>

  </div>

</body>

</html>