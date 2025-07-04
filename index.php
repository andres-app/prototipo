<?php
session_start();

if (isset($_GET['url']) && !empty($_GET['url'])) {
    $ruta = explode('/', trim($_GET['url'], '/'));
    $page = $ruta[0]; // ejemplo: riesgos
} elseif (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'dashboard';
}


// Acción de login (simulada)
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $_SESSION['logueado'] = true;
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?')); // evita problemas con ?page
    exit;
}

// Acción de logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Si NO está logueado, mostrar solo el login y salir
if (!isset($_SESSION['logueado'])):
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Login SGSI ETNA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="max-w-md mx-auto bg-white p-10 rounded-2xl shadow-2xl">
            <div class="flex justify-center mb-4">
                <img src="https://www.etna.com.pe/wp-content/themes/hanan_etna/img/etna-slogan.png" alt="Logo ETNA" class="h-14">
            </div>
            <h2 class="text-2xl font-bold mb-6 text-center text-indigo-800">Iniciar Sesión SGSI - ETNA</h2>
            <form method="post">
                <input type="hidden" name="action" value="login">
                <div class="mb-4">
                    <label class="block mb-1">Usuario</label>
                    <input type="text" class="w-full border rounded-lg px-4 py-2" value="admin.etna" readonly>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Contraseña</label>
                    <input type="password" class="w-full border rounded-lg px-4 py-2" value="********" readonly>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Código MFA (simulado)</label>
                    <input type="text" class="w-full border rounded-lg px-4 py-2" placeholder="123456">
                </div>
                <button class="w-full bg-indigo-700 text-white py-2 rounded-lg font-bold hover:bg-indigo-800 transition">Ingresar</button>
            </form>
        </div>
    </body>

    </html>
<?php exit;
endif; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Portal SGSI - ETNA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-md px-4 py-2 flex items-center justify-between w-full">
        <!-- Botón hamburguesa (solo móvil) -->
        <button id="menuBtn" class="mr-3 block md:hidden focus:outline-none">
            <svg class="w-8 h-8 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <!-- Logo ETNA -->
        <div class="flex items-center gap-2 flex-shrink-0">
            <img src="https://www.etna.com.pe/wp-content/themes/hanan_etna/img/etna-slogan.png" alt="Logo ETNA" class="h-12 md:h-14 w-auto" />
            <!-- “SGSI” visible solo en md+ -->

        </div>
        <!-- Usuario/derecha -->
        <div class="relative flex items-center gap-2">
            <button id="userMenuBtn" class="flex items-center gap-2 focus:outline-none">
                <!-- Ícono usuario -->
                <svg class="w-7 h-7 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M6 20v-2a6 6 0 0 1 12 0v2" />
                </svg>
                <span class="font-bold text-gray-700">Administrador</span>
                <!-- Flecha abajo -->
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </button>
            <!-- Dropdown -->
            <div id="userDropdown" class="hidden absolute right-0 top-full mt-1 w-48 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-100">
                <a href="#" class="block px-5 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
                <a href="#" class="block px-5 py-2 text-gray-700 hover:bg-indigo-50">Configuración</a>
                <div class="border-t border-gray-100 my-2"></div>
                <a href="?logout=1" class="block px-5 py-2 text-rose-700 hover:bg-rose-50 font-semibold">Cerrar sesión</a>
            </div>
        </div>


    </header>



    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-white w-64 min-h-screen shadow-lg pt-8 md:static md:block hidden md:flex">
            <ul class="space-y-2">
                <li>
                    <a href="/prototipo/dashboard"
                        class="flex items-center px-6 py-3 font-semibold gap-3 transition
               <?php echo ($page == 'dashboard') ? 'bg-indigo-100 text-indigo-700 shadow rounded-l-xl' : 'hover:bg-indigo-50 text-gray-700'; ?>">
                        <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 12L2 13m0 0l10 9 10-9M2 13V7a2 2 0 0 1 2-2h3m14 8V7a2 2 0 0 0-2-2h-3M12 22V13m0 0L2 13"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/prototipo/activos"
                        class="flex items-center px-6 py-3 font-semibold gap-3 transition
               <?php echo ($page == 'activos') ? 'bg-indigo-100 text-indigo-700 shadow rounded-l-xl' : 'hover:bg-indigo-50 text-gray-700'; ?>">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="13" width="18" height="8" rx="2" />
                            <path d="M3 13V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6" />
                            <circle cx="7.5" cy="17.5" r="1.5" />
                            <circle cx="16.5" cy="17.5" r="1.5" />
                        </svg>
                        Gestión de Activos
                    </a>
                </li>
                <li>
                    <a href="/prototipo/riesgos"
                        class="flex items-center px-6 py-3 font-semibold gap-3 transition
               <?php echo ($page == 'riesgos') ? 'bg-indigo-100 text-indigo-700 shadow rounded-l-xl' : 'hover:bg-indigo-50 text-gray-700'; ?>">
                        <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3l-8.47-14.14a2 2 0 0 0-3.42 0z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                        Gestión de Riesgos
                    </a>
                </li>
                <li>
                    <a href="/prototipo/incidentes"
                        class="flex items-center px-6 py-3 font-semibold gap-3 transition
               <?php echo ($page == 'incidentes') ? 'bg-indigo-100 text-indigo-700 shadow rounded-l-xl' : 'hover:bg-indigo-50 text-gray-700'; ?>">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="7" y="8" width="10" height="8" rx="4" />
                            <path d="M3 12h2m14 0h2m-6 4v2m0-10V4m-7 4L4 6m16 2l-3-2" />
                        </svg>
                        Incidentes
                    </a>
                </li>
                <li>
                    <a href="/prototipo/politicas"
                        class="flex items-center px-6 py-3 font-semibold gap-3 transition
               <?php echo ($page == 'politicas') ? 'bg-indigo-100 text-indigo-700 shadow rounded-l-xl' : 'hover:bg-indigo-50 text-gray-700'; ?>">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                        Políticas
                    </a>
                </li>
                <li>
                    <a href="/prototipo/usuarios"
                        class="flex items-center px-6 py-3 font-semibold gap-3 transition
               <?php echo ($page == 'usuarios') ? 'bg-indigo-100 text-indigo-700 shadow rounded-l-xl' : 'hover:bg-indigo-50 text-gray-700'; ?>">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-3-3.87M7 21v-2a4 4 0 0 1 3-3.87M9 7a4 4 0 1 1 8 0a4 4 0 0 1-8 0Z" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87M1 21v-2a4 4 0 0 1 3-3.87" />
                        </svg>
                        Usuarios
                    </a>
                </li>
                <li>
                    <a href="/prototipo/reportes"
                        class="flex items-center px-6 py-3 font-semibold gap-3 transition
               <?php echo ($page == 'reportes') ? 'bg-indigo-100 text-indigo-700 shadow rounded-l-xl' : 'hover:bg-indigo-50 text-gray-700'; ?>">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="12" y1="20" x2="12" y2="10" />
                            <line x1="18" y1="20" x2="18" y2="4" />
                            <line x1="6" y1="20" x2="6" y2="16" />
                        </svg>
                        Reportes
                    </a>
                </li>
                <li>
                    <a href="/prototipo/alertas"
                        class="flex items-center px-6 py-3 font-semibold gap-3 transition
               <?php echo ($page == 'alertas') ? 'bg-indigo-100 text-indigo-700 shadow rounded-l-xl' : 'hover:bg-indigo-50 text-gray-700'; ?>">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        Alertas
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Overlay para móvil -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-30 z-30 hidden md:hidden"></div>
        <!-- Main Content -->
        <main class="flex-1 w-full p-4 md:p-8 ml-0 transition-all duration-300">
            <?php

            if ($page == 'dashboard') { ?>
                <!-- Aquí va el dashboard -->
                <h1 class="text-3xl font-bold text-indigo-900 mb-6">Dashboard SGSI ETNA</h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="text-3xl font-bold text-indigo-700">8</div>
                        <div class="text-gray-600 mt-2">Activos Críticos</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="text-3xl font-bold text-rose-700">3</div>
                        <div class="text-gray-600 mt-2">Riesgos Críticos</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="text-3xl font-bold text-green-600">5</div>
                        <div class="text-gray-600 mt-2">Controles Implementados</div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-xl">
                    <h2 class="text-xl font-bold text-indigo-900 mb-4">Últimas Alertas</h2>
                    <ul class="space-y-3">
                        <li class="flex items-center"><span class="w-3 h-3 rounded-full bg-rose-500 mr-2"></span> Incidente de seguridad reportado en SAP ERP</li>
                        <li class="flex items-center"><span class="w-3 h-3 rounded-full bg-yellow-400 mr-2"></span> Backup completado exitosamente</li>
                        <li class="flex items-center"><span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span> Capacitación completada por 12 usuarios</li>
                    </ul>
                </div>
            <?php
            } elseif ($page == 'activos') { ?>
                <h1 class="text-2xl font-bold text-indigo-900 mb-6">Gestión de Activos</h1>
                <div class="overflow-x-auto w-full">
                    <table class="min-w-full bg-white shadow-md rounded-xl">
                        <thead class="bg-indigo-900 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Activo</th>
                                <th class="py-3 px-4 text-left">Tipo</th>
                                <th class="py-3 px-4 text-left">Ubicación</th>
                                <th class="py-3 px-4 text-left">Responsable</th>
                                <th class="py-3 px-4 text-left">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4">A-01</td>
                                <td class="py-2 px-4">SAP ERP</td>
                                <td class="py-2 px-4">Software</td>
                                <td class="py-2 px-4">Central</td>
                                <td class="py-2 px-4">Jefe de TI</td>
                                <td class="py-2 px-4"><span class="px-2 py-1 rounded-full bg-green-200 text-green-700">Activo</span></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4">A-02</td>
                                <td class="py-2 px-4">Servidor Documental</td>
                                <td class="py-2 px-4">Hardware</td>
                                <td class="py-2 px-4">Ventanilla</td>
                                <td class="py-2 px-4">Jefe de TI</td>
                                <td class="py-2 px-4"><span class="px-2 py-1 rounded-full bg-green-200 text-green-700">Activo</span></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4">A-03</td>
                                <td class="py-2 px-4">Laptop Finanzas</td>
                                <td class="py-2 px-4">Hardware</td>
                                <td class="py-2 px-4">Central</td>
                                <td class="py-2 px-4">Gerente Finanzas</td>
                                <td class="py-2 px-4"><span class="px-2 py-1 rounded-full bg-yellow-200 text-yellow-700">En riesgo</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            } elseif ($page == 'riesgos') { ?>
                <h1 class="text-2xl font-bold text-indigo-900 mb-6">Gestión de Riesgos</h1>
                <div class="overflow-x-auto w-full">
                    <table class="min-w-full bg-white shadow-md rounded-xl">
                        <thead class="bg-rose-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Riesgo</th>
                                <th class="py-3 px-4 text-left">Activo</th>
                                <th class="py-3 px-4 text-left">Prob.</th>
                                <th class="py-3 px-4 text-left">Impacto</th>
                                <th class="py-3 px-4 text-left">Nivel</th>
                                <th class="py-3 px-4 text-left">Tratamiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4">R-01</td>
                                <td class="py-2 px-4">Acceso no autorizado a SAP</td>
                                <td class="py-2 px-4">SAP ERP</td>
                                <td class="py-2 px-4">Alta</td>
                                <td class="py-2 px-4">Alto</td>
                                <td class="py-2 px-4"><span class="px-2 py-1 rounded-full bg-rose-200 text-rose-700">Crítico</span></td>
                                <td class="py-2 px-4">MFA, monitoreo</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4">R-02</td>
                                <td class="py-2 px-4">Robo de laptop</td>
                                <td class="py-2 px-4">Laptop Finanzas</td>
                                <td class="py-2 px-4">Media</td>
                                <td class="py-2 px-4">Alto</td>
                                <td class="py-2 px-4"><span class="px-2 py-1 rounded-full bg-yellow-200 text-yellow-700">Alto</span></td>
                                <td class="py-2 px-4">Encriptar, backup</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            } elseif ($page == 'incidentes') { ?>
                <h1 class="text-2xl font-bold text-indigo-900 mb-6">Registro de Incidentes</h1>
                <div class="mb-6">
                    <form class="bg-white p-6 rounded-xl shadow-md flex flex-col md:flex-row gap-4">
                        <input type="text" placeholder="Área" class="border rounded-lg px-4 py-2 flex-1" value="Finanzas">
                        <input type="text" placeholder="Descripción" class="border rounded-lg px-4 py-2 flex-1" value="Intento de acceso indebido a SAP">
                        <button class="bg-indigo-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-indigo-800">Registrar</button>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white shadow-md rounded-xl">
                        <thead class="bg-indigo-800 text-white">
                            <tr>
                                <th class="py-3 px-4">Fecha</th>
                                <th class="py-3 px-4">Área</th>
                                <th class="py-3 px-4">Descripción</th>
                                <th class="py-3 px-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4">03/07/2025</td>
                                <td class="py-2 px-4">Finanzas</td>
                                <td class="py-2 px-4">Acceso indebido a SAP</td>
                                <td class="py-2 px-4"><span class="px-2 py-1 rounded-full bg-green-200 text-green-700">Cerrado</span></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4">05/07/2025</td>
                                <td class="py-2 px-4">Comercial</td>
                                <td class="py-2 px-4">Phishing detectado</td>
                                <td class="py-2 px-4"><span class="px-2 py-1 rounded-full bg-yellow-200 text-yellow-700">Abierto</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            } elseif ($page == 'politicas') { ?>
                <h1 class="text-2xl font-bold text-indigo-900 mb-4 flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M8 17l4 4 4-4m-4-5v9" />
                        <path d="M20 12V8a2 2 0 0 0-2-2h-4V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h7" />
                    </svg>
                    Políticas y Documentos
                </h1>
                <div id="policies-accordion"
                    class="bg-white rounded-2xl shadow-xl p-4 space-y-3 max-w-5xl mx-auto">

                    <!-- POLÍTICA 1 -->
                    <div class="policy-item group bg-white rounded-xl transition-shadow duration-300">
                        <button type="button"
                            class="policy-toggle flex items-center w-full justify-between px-6 py-4 text-left font-bold text-lg text-indigo-800 rounded-xl focus:outline-none group-hover:bg-indigo-50 border-2 border-transparent transition-all duration-300">
                            <span class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4" />
                                </svg>
                                Política de Seguridad de la Información
                            </span>
                            <svg class="w-6 h-6 transition-transform duration-500 ease-in-out text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 14l-6-6h12l-6 6z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="policy-content overflow-hidden max-h-0 opacity-0 transition-all duration-500 px-8">
                            <div class="pt-2 pb-5 text-gray-800 text-base leading-relaxed">
                                En ETNA, todos los colaboradores tienen la responsabilidad de proteger la <span class="font-bold text-indigo-700">confidencialidad</span>, <span class="font-bold text-indigo-700">integridad</span> y <span class="font-bold text-indigo-700">disponibilidad</span> de la información.<br>
                                Es obligatorio cumplir con las directrices del SGSI, participar en capacitaciones y reportar cualquier incidente al área de TI para una gestión oportuna y segura.
                                <div class="mt-4">
                                    <a href="#" class="text-indigo-600 font-semibold hover:underline flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M13 16h-1v-4h-1m2-4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                                        </svg>
                                        Ver documento PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- POLÍTICA 2 -->
                    <div class="policy-item group bg-white rounded-xl transition-shadow duration-300">
                        <button type="button"
                            class="policy-toggle flex items-center w-full justify-between px-6 py-4 text-left font-bold text-lg text-indigo-800 rounded-xl focus:outline-none group-hover:bg-yellow-50 border-2 border-transparent transition-all duration-300">
                            <span class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="8" width="18" height="13" rx="2" />
                                    <path d="M16 2v4M8 2v4M4 10h16" />
                                </svg>
                                Política de Control de Acceso
                            </span>
                            <svg class="w-6 h-6 transition-transform duration-500 ease-in-out text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 14l-6-6h12l-6 6z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="policy-content overflow-hidden max-h-0 opacity-0 transition-all duration-500 px-8">
                            <div class="pt-2 pb-5 text-gray-800 text-base leading-relaxed">
                                El acceso a sistemas y datos se gestiona bajo el <span class="font-bold text-indigo-700">principio de menor privilegio</span>, usando autenticación robusta (MFA) y procedimientos formales para altas y bajas de usuarios. La vigilancia y auditoría periódica son esenciales para garantizar la seguridad y trazabilidad en todo momento.
                                <div class="mt-4">
                                    <a href="#" class="text-indigo-600 font-semibold hover:underline flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M13 16h-1v-4h-1m2-4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                                        </svg>
                                        Ver documento PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } elseif ($page == 'usuarios') { ?>
                <h1 class="text-2xl font-bold text-indigo-900 mb-6">Gestión de Usuarios</h1>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white shadow-md rounded-xl">
                        <thead class="bg-indigo-900 text-white">
                            <tr>
                                <th class="py-3 px-4">Usuario</th>
                                <th class="py-3 px-4">Nombre</th>
                                <th class="py-3 px-4">Rol</th>
                                <th class="py-3 px-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4">admin.etna</td>
                                <td class="py-2 px-4">Ana García</td>
                                <td class="py-2 px-4">Administrador</td>
                                <td class="py-2 px-4"><span class="px-2 py-1 rounded-full bg-green-200 text-green-700">Activo</span></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4">jperez</td>
                                <td class="py-2 px-4">Juan Pérez</td>
                                <td class="py-2 px-4">Usuario</td>
                                <td class="py-2 px-4"><span class="px-2 py-1 rounded-full bg-yellow-200 text-yellow-700">Pendiente</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            } elseif ($page == 'reportes') { ?>
                <h1 class="text-2xl font-bold text-indigo-900 mb-6 flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 3h18v4H3V3zm0 6h18v12H3V9zm4 4h2v4H7v-4zm4 0h2v4h-2v-4zm4 0h2v4h-2v-4z" />
                    </svg>
                    Reportes
                </h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Reporte de Incidentes -->
                    <a href="#" class="group block bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-gray-100 hover:border-indigo-300 p-6 cursor-pointer">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-rose-100 rounded-full p-2">
                                <svg class="w-7 h-7 text-rose-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                                </svg>
                            </div>
                            <span class="font-bold text-lg text-rose-700">Incidentes</span>
                        </div>
                        <div class="text-gray-700 mb-3 text-sm">
                            Reporte detallado de incidentes de seguridad, estados y análisis de tendencias.
                        </div>
                        <span class="inline-block bg-rose-100 text-rose-600 text-xs font-semibold px-3 py-1 rounded-full group-hover:bg-rose-600 group-hover:text-white transition">Ver reporte</span>
                    </a>
                    <!-- Reporte de Activos -->
                    <a href="#" class="group block bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-gray-100 hover:border-green-300 p-6 cursor-pointer">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-green-100 rounded-full p-2">
                                <svg class="w-7 h-7 text-green-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="13" width="18" height="8" rx="2" />
                                    <circle cx="7.5" cy="17.5" r="1.5" />
                                    <circle cx="16.5" cy="17.5" r="1.5" />
                                </svg>
                            </div>
                            <span class="font-bold text-lg text-green-700">Activos</span>
                        </div>
                        <div class="text-gray-700 mb-3 text-sm">
                            Inventario actualizado de activos críticos, asignaciones y estado de los equipos.
                        </div>
                        <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full group-hover:bg-green-600 group-hover:text-white transition">Ver reporte</span>
                    </a>
                    <!-- Reporte de Usuarios -->
                    <a href="#" class="group block bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-gray-100 hover:border-indigo-400 p-6 cursor-pointer">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-indigo-100 rounded-full p-2">
                                <svg class="w-7 h-7 text-indigo-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M17 21v-2a4 4 0 0 0-3-3.87M7 21v-2a4 4 0 0 1 3-3.87M9 7a4 4 0 1 1 8 0a4 4 0 0 1-8 0Z" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M1 21v-2a4 4 0 0 1 3-3.87" />
                                </svg>
                            </div>
                            <span class="font-bold text-lg text-indigo-700">Usuarios</span>
                        </div>
                        <div class="text-gray-700 mb-3 text-sm">
                            Análisis de usuarios, roles, accesos y actividad reciente en el sistema.
                        </div>
                        <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full group-hover:bg-indigo-600 group-hover:text-white transition">Ver reporte</span>
                    </a>
                </div>

            <?php
            } elseif ($page == 'alertas') { ?>
                <h1 class="text-2xl font-bold text-indigo-900 mb-6 flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    Alertas y Notificaciones
                </h1>

                <div class="bg-white p-6 rounded-xl shadow-md">
                    <ul class="space-y-4">
                        <!-- Alerta crítica -->
                        <li class="flex items-center gap-3 group transition">
                            <span class="relative flex h-5 w-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-5 w-5 bg-rose-500"></span>
                            </span>
                            <div>
                                <span class="font-semibold text-rose-700 group-hover:underline transition">Intento de acceso indebido en SAP</span>
                                <span class="ml-2 text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full font-semibold">Crítico</span>
                                <span class="ml-3 text-gray-400 text-xs">03/07/2025</span>
                            </div>
                            <svg class="w-5 h-5 ml-auto text-rose-500 opacity-60 group-hover:text-rose-700 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                            </svg>
                        </li>
                        <!-- Alerta advertencia -->
                        <li class="flex items-center gap-3 group transition">
                            <span class="relative flex h-5 w-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-5 w-5 bg-yellow-500"></span>
                            </span>
                            <div>
                                <span class="font-semibold text-yellow-700 group-hover:underline transition">Backup finalizado</span>
                                <span class="ml-2 text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-semibold">Advertencia</span>
                                <span class="ml-3 text-gray-400 text-xs">02/07/2025</span>
                            </div>
                            <svg class="w-5 h-5 ml-auto text-yellow-500 opacity-60 group-hover:text-yellow-700 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 8v4m0 4h.01" />
                            </svg>
                        </li>
                        <!-- Alerta éxito -->
                        <li class="flex items-center gap-3 group transition">
                            <span class="relative flex h-5 w-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-5 w-5 bg-green-500"></span>
                            </span>
                            <div>
                                <span class="font-semibold text-green-700 group-hover:underline transition">Usuario registrado exitosamente</span>
                                <span class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-semibold">Éxito</span>
                                <span class="ml-3 text-gray-400 text-xs">01/07/2025</span>
                            </div>
                            <svg class="w-5 h-5 ml-auto text-green-500 opacity-60 group-hover:text-green-700 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M8 12l2 2 4-4" />
                            </svg>
                        </li>
                    </ul>
                </div>

            <?php
            } else {
                echo '<h2 class="text-xl font-bold text-rose-700">Página no encontrada</h2>';
            }
            ?>
        </main>
    </div>
    <!-- Toast container -->
    <div id="toast-container" class="fixed bottom-8 right-8 flex text-white flex-col-reverse gap-4 z-50"></div>

    <script>
        // Mensajes de alerta con tipo
        const alerts = [{
                msg: "Incidente de seguridad reportado en SAP ERP",
                type: "danger"
            },
            {
                msg: "Backup completado exitosamente",
                type: "success"
            },
            {
                msg: "Usuario bloqueado por intento de acceso indebido",
                type: "warning"
            },
            {
                msg: "Capacitación de seguridad completada por 12 usuarios",
                type: "info"
            },
            {
                msg: "Nuevo dispositivo conectado a la red",
                type: "info"
            },
            {
                msg: "Cambio de política de contraseñas programado",
                type: "warning"
            },
            {
                msg: "Phishing detectado en área Comercial",
                type: "danger"
            }
        ];

        // Mezclar el array de alertas para que el orden sea aleatorio cada vez
        function shuffle(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
        }
        shuffle(alerts); // ¡Desordena el array al cargar la página!

        let alertIndex = 0;

        // Colores Tailwind por tipo
        const colorMap = {
            danger: "bg-rose-600",
            warning: "bg-yellow-400",
            success: "bg-green-600",
            info: "bg-indigo-600"
        };

        // Iconos SVG por tipo
        function toastIcon(type) {
            switch (type) {
                case "danger":
                    return `<svg width="24" height="24" fill="none"><circle cx="12" cy="12" r="12" fill="#F43F5E"/><path d="M12 7v4m0 4h.01" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
                case "warning":
                    return `<svg width="24" height="24" fill="none"><circle cx="12" cy="12" r="12" fill="#F59E42"/><path d="M12 8v4m0 4h.01" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
                case "success":
                    return `<svg width="24" height="24" fill="none"><circle cx="12" cy="12" r="12" fill="#22C55E"/><path d="M8 12l2 2l4-4" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
                default:
                    return `<svg width="24" height="24" fill="none"><circle cx="12" cy="12" r="12" fill="#6366F1"/><path d="M12 8v4m0 4h.01" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
            }
        }

        // Mostrar toast "apilado"
        function showStackedToast(msg, type) {
            const toastContainer = document.getElementById("toast-container");
            const toast = document.createElement("div");
            toast.className = `flex items-center gap-3 px-6 py-4 mb-1 rounded-2xl shadow-2xl min-w-[270px] max-w-xs animate-slidein opacity-0 pointer-events-auto cursor-pointer ${colorMap[type] ?? colorMap["info"]}`;
            toast.style.transition = "opacity 0.6s";
            toast.innerHTML = `
            ${toastIcon(type)}
            <span class="flex-1">${msg}</span>
            <button onclick="this.parentNode.style.opacity=0; setTimeout(()=>this.parentNode.remove(),600)" class="text-white/70 hover:text-white text-lg font-bold ml-2">&times;</button>
        `;
            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = "1";
            }, 100);

            setTimeout(() => {
                toast.style.opacity = "0";
                setTimeout(() => toast.remove(), 600);
            }, 5000);
        }

        // Toasts cada 10s
        function cycleStackedToasts() {
            let alert = alerts[alertIndex];
            showStackedToast(alert.msg, alert.type);
            alertIndex = (alertIndex + 1) % alerts.length;
            setTimeout(cycleStackedToasts, 10000);
        }

        // Animación personalizada para el toast
        const style = document.createElement("style");
        style.innerHTML = `
        @keyframes slidein {
            from { transform: translateY(40px); opacity: 0; }
            to   { transform: translateY(0); opacity: 1; }
        }
        .animate-slidein { animation: slidein 0.5s cubic-bezier(.32,.72,0,1.26);}
    `;
        document.head.appendChild(style);

        // Lanzar toasts al cargar la página
        window.onload = function() {
            cycleStackedToasts();
        }

        // Dropdown de usuario (no quitar si usas el header de usuario con menú)
        document.addEventListener("DOMContentLoaded", function() {
            const btn = document.getElementById("userMenuBtn");
            const dropdown = document.getElementById("userDropdown");
            document.addEventListener("click", function(event) {
                if (btn && btn.contains(event.target)) {
                    dropdown.classList.toggle("hidden");
                } else if (dropdown && !dropdown.contains(event.target)) {
                    dropdown.classList.add("hidden");
                }
            });
        });

        // Accordion: Solo uno abierto y animación visual
        document.querySelectorAll('#policies-accordion .policy-toggle').forEach((btn, idx, btns) => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('#policies-accordion .policy-item').forEach((item, i) => {
                    const content = item.querySelector('.policy-content');
                    const arrow = item.querySelector('svg:last-child');
                    if (i === idx) {
                        // Activar visualmente
                        btn.classList.add('border-indigo-400', 'bg-indigo-50', 'shadow-lg');
                        content.classList.remove('max-h-0', 'opacity-0');
                        content.classList.add('max-h-[500px]', 'opacity-100');
                        arrow.classList.add('rotate-180', 'text-indigo-600');
                        item.classList.add('ring-2', 'ring-indigo-100');
                    } else {
                        // Desactivar visualmente
                        btn.classList.remove('border-indigo-400', 'bg-indigo-50', 'shadow-lg');
                        content.classList.add('max-h-0', 'opacity-0');
                        content.classList.remove('max-h-[500px]', 'opacity-100');
                        arrow.classList.remove('rotate-180', 'text-indigo-600');
                        item.classList.remove('ring-2', 'ring-indigo-100');
                    }
                });
            });
        });
        // Abre la primera al cargar
        setTimeout(() => document.querySelector('#policies-accordion .policy-toggle').click(), 50);
    </script>
</body>

</html>