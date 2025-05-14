<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - PT. Hakuna Matata</title>

  {{-- CSRF token for any JS/AJAX --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Tailwind via CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- FontAwesome --}}
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    rel="stylesheet"
  />

  {{-- Google Font Orbitron --}}
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Orbitron&display=swap");
    body {
      font-family: "Orbitron", sans-serif;
    }
  </style>
</head>
<body class="bg-white min-h-screen relative overflow-x-hidden">

  <!-- Top half blue background -->
  <div class="absolute top-0 left-0 w-full h-1/2 bg-[#2f7a95] rounded-br-[80px] z-0"></div>

  <!-- Logo -->
  <div class="absolute top-6 left-6 flex items-center space-x-2 z-20">
    <img
      src="https://storage.googleapis.com/a1aa/image/0f4ca261-12be-4f39-fccc-3d2f0cc2fdf3.jpg"
      alt="Logo PT. Hakuna Matata"
      class="w-6 h-6"
      width="24"
      height="24"
    />
    <span class="text-white text-lg font-semibold tracking-wide select-none leading-none">
      PT. Hakuna Matata
    </span>
  </div>

  <!-- Centered login form -->
  <div class="flex items-center justify-center min-h-screen px-6 relative z-10">
    <form
      method="POST"
      action="{{ route('login.submit') }}"
      class="bg-white rounded-[20px] shadow-lg p-8 max-w-[480px] w-full"
      style="backdrop-filter: blur(8px); background-color: rgba(143, 184, 196, 0.6); margin-top: 120px;"
    >
      @csrf

      <h2 class="text-[#2f7a95] text-[28px] font-semibold mb-6 text-center select-none leading-tight">
        Login
      </h2>

      {{-- Email --}}
      <div class="mb-5">
        <div class="flex items-center bg-white rounded-lg shadow-sm border border-gray-200" style="height: 40px;">
          <span class="pl-3 text-gray-400 text-sm"><i class="fas fa-envelope"></i></span>
          <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            placeholder="Enter your email"
            class="w-full py-2 px-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2f7a95] text-gray-500 text-sm"
            style="height: 40px;"
          />
        </div>
        @error('email')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div class="mb-5">
        <div class="flex items-center bg-white rounded-lg shadow-sm border border-gray-200" style="height: 40px;">
          <span class="pl-3 text-gray-400 text-sm"><i class="fas fa-lock"></i></span>
          <input
            type="password"
            name="password"
            required
            placeholder="Enter your password"
            class="w-full py-2 px-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2f7a95] text-gray-500 text-sm"
            style="height: 40px;"
          />
        </div>
        @error('password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Forgot Password --}}
      <div class="mb-4 text-[10px] text-[#2f7a95]">
        <a href="#" class="hover:underline select-none">Forgot your password?</a>
      </div>

      {{-- Submit --}}
      <button
        type="submit"
        class="bg-[#2f7a95] text-white font-semibold text-sm py-2 px-6 rounded-md shadow-md hover:bg-[#276a7f] transition-colors select-none float-right"
        style="height: 36px; min-width: 90px;"
      >
        Submit
      </button>
      <div class="clear-both"></div>
    </form>
  </div>
</body>
</html>
