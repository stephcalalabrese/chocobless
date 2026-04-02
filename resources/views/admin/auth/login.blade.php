<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Iniciar sesión — ChocoBless Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center bg-amber-50">
<div class="w-full max-w-md px-4">
  <div class="text-center mb-8">
    <div class="text-5xl mb-2">🍫</div>
    <h1 class="text-2xl font-bold text-amber-900">ChocoBless Admin</h1>
    <p class="text-sm text-gray-500 mt-1">Panel de administración</p>
  </div>
  <div class="bg-white rounded-2xl shadow p-8">
    @if(session('error'))
      <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
          placeholder="diana@choco-bless.com">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
        <input type="password" name="mot_de_passe" required
          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
      </div>
      <button type="submit"
        class="w-full bg-amber-800 hover:bg-amber-900 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
        Iniciar sesión
      </button>
    </form>
  </div>
</div>
</body>
</html>