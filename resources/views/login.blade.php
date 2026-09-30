<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Repuestos Los Chamos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* FIX: Evita que el autocompletado de Chrome ponga las cajas blancas en el Modo Oscuro */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #09090b inset !important; /* Mantiene el fondo oscuro */
            -webkit-text-fill-color: white !important; /* Mantiene la letra blanca */
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="flex h-screen bg-zinc-950 overflow-hidden text-white font-sans selection:bg-red-600 selection:text-white">

    <!-- Lado Izquierdo: Imagen de Fondo y Logo -->
    <div class="hidden md:flex md:w-1/2 bg-black relative items-center justify-center border-r border-zinc-800">
        
        <div class="absolute inset-0 bg-cover bg-center opacity-40 grayscale" 
             style="background-image: url('https://images.unsplash.com/photo-1586191582152-f94b150c2688?q=80&w=1000&auto=format&fit=crop');">
        </div>
        
        <div class="absolute inset-0 bg-gradient-to-t from-black via-zinc-950/80 to-transparent"></div>

        <div class="relative z-10 flex flex-col items-center text-center px-12">
            
            <!-- Carga del Logo desde la carpeta public de Laravel -->
            <img src="{{ asset('logo.png') }}" alt="Logo Repuestos Los Chamos" class="w-64 md:w-72 h-auto object-contain mb-8 drop-shadow-[0_0_25px_rgba(0,0,0,0.9)]">

            <h2 class="text-4xl lg:text-5xl font-bold uppercase tracking-widest mb-4 border-b-4 border-red-600 inline-block pb-2 text-white shadow-black drop-shadow-lg">
                Fuerza Diesel
            </h2>
            <p class="text-xl text-zinc-300 font-medium tracking-wide drop-shadow-md">El motor de tu negocio, siempre en marcha.</p>
        </div>
    </div>

    <!-- Lado Derecho: Formulario de Login -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-zinc-950 relative">
        
        <div class="absolute top-0 right-0 w-64 h-64 bg-red-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 pointer-events-none"></div>

        <div class="w-full max-w-md p-8 relative z-10">
            
            <div class="text-center mb-8">
                <h1 class="text-xl sm:text-2xl font-bold uppercase tracking-wider text-white whitespace-nowrap">
                    Repuestos <span class="text-red-600">Los Chamos</span>
                </h1>
                <p class="text-zinc-500 mt-2 text-[10px] font-bold uppercase tracking-widest">
                    Acceso Administrativo
                </p>
            </div>

            <!-- Muestra de alerta si hay errores de validación de Laravel -->
            @if ($errors->any())
                <div class="mb-5 p-4 rounded-lg bg-red-950/80 border border-red-600/50 text-red-200 text-xs">
                    <p class="font-bold mb-1">Error de Autenticación:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- ESTRUCTURA BACKEND: Apuntado a la ruta POST de Laravel -->
            <form action="{{ route('login') }}" method="POST" class="bg-zinc-900/40 backdrop-blur-md p-8 rounded-2xl shadow-[0_0_40px_rgba(0,0,0,0.5)] border border-zinc-800/50">
                
                <!-- Token CSRF obligatorio en Laravel -->
                @csrf

                <!-- Campo Usuario -->
                <div class="mb-5">
                    <label class="block text-zinc-400 text-[10px] font-bold mb-2 uppercase tracking-widest" for="username">
                        Usuario
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <!-- Conserva el valor escrito previamente en caso de error mediante old() -->
                        <input class="w-full pl-10 pr-4 py-3 bg-zinc-950/50 border border-zinc-800 rounded-lg text-white placeholder-zinc-600 focus:bg-black focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all" 
                               id="username"
                               name="username" 
                               value="{{ old('username') }}"
                               type="text" 
                               placeholder="Ej: vendedor.principal"
                               required 
                               autofocus>
                    </div>
                </div>
                
                <!-- Campo Contraseña -->
                <div class="mb-6">
                    <label class="block text-zinc-400 text-[10px] font-bold mb-2 uppercase tracking-widest" for="password">
                        Contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input class="w-full pl-10 pr-10 py-3 bg-zinc-950/50 border border-zinc-800 rounded-lg text-white placeholder-zinc-600 focus:bg-black focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all" 
                               id="password"
                               name="password" 
                               type="password" 
                               placeholder="••••••••"
                               required>
                        <!-- Ojito Visor -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-zinc-500 hover:text-white transition" id="togglePassword">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center text-xs text-zinc-400 cursor-pointer hover:text-white transition">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="mr-2 w-4 h-4 accent-red-600 bg-zinc-900 border-zinc-700 rounded cursor-pointer">
                        Recordarme
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-red-500 hover:text-red-400 transition-colors">¿Olvidó su clave?</a>
                    @else
                        <a href="#" class="text-xs text-red-500 hover:text-red-400 transition-colors">¿Olvidó su clave?</a>
                    @endif
                </div>
                
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg shadow-[0_0_15px_rgba(220,38,38,0.3)] transition-all duration-300 transform hover:-translate-y-0.5 uppercase tracking-widest text-sm">
                    Ingresar al Sistema
                </button>
                
            </form>
        </div>
    </div>

    <!-- Script del ojito -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
        });
    </script>
</body>
</html>