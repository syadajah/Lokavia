<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lokavia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</head>

<body class="min-h-screen bg-linear-to-br from-blue-400 via-blue-500 to-blue-600 flex items-center justify-center p-6">

    {{-- 🔥 POPUP VALIDATION ERROR --}}
    @if ($errors->any())
        <div id="popup"
            class="fixed top-5 right-5 z-50 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slideDown">
            <iconify-icon icon="mdi:alert-circle" class="text-xl"></iconify-icon>
            <div>
                <p class="font-semibold">Login Failed</p>
                <ul class="text-sm list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="closePopup()" class="ml-3 text-white">
                <iconify-icon icon="mdi:close"></iconify-icon>
            </button>
        </div>
    @endif

    {{-- 🔥 POPUP SUCCESS (Misal dari register redirect) --}}
    @if (session('success'))
        <div id="popup"
            class="fixed top-5 right-5 z-50 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slideDown">
            <iconify-icon icon="mdi:check-circle" class="text-xl"></iconify-icon>
            <p>{{ session('success') }}</p>
            <button onclick="closePopup()" class="ml-3 text-white">
                <iconify-icon icon="mdi:close"></iconify-icon>
            </button>
        </div>
    @endif

    {{-- SCRIPT AUTO CLOSE POPUP --}}
    <script>
        function closePopup() {
            const popup = document.getElementById('popup');
            if (popup) popup.remove();
        }

        setTimeout(() => {
            closePopup();
        }, 3000);
    </script>


    <div
        class="w-full max-w-md bg-white/90 shadow-xl backdrop-blur-lg rounded-2xl p-8 animate-fadeIn border-blue-400 border-2">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">Welcome Back 👋</h2>
        <p class="text-center text-gray-500 mb-6">Sign in to continue your journey</p>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 mb-1 font-medium">Email</label>
                <input type="email" name="email"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="you@example.com" required>
            </div>

            <div>
                <label class="block text-gray-700 mb-1 font-medium">Password</label>

                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="••••••••" required>

                    <span id="togglePass"
                        class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-500">
                        <iconify-icon icon="mdi:eye-off"></iconify-icon>
                    </span>
                </div>
            </div>

            <script>
                const passwordInput = document.getElementById("password");
                const togglePass = document.getElementById("togglePass");
                const icon = togglePass.querySelector("iconify-icon");

                togglePass.addEventListener("click", () => {
                    const hidden = passwordInput.type === "password";
                    passwordInput.type = hidden ? "text" : "password";
                    icon.setAttribute("icon", hidden ? "mdi:eye" : "mdi:eye-off");
                });
            </script>

            <button
                class="w-full py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">Login</button>
        </form>

        <p class="mt-6 text-center text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Register</a>
        </p>
    </div>

</body>


</html>
