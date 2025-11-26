<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Lokavia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</head>

<body class="min-h-screen bg-linear-to-br from-blue-600 via-blue-500 to-blue-400 flex items-center justify-center p-6">

    @if (session('registered'))
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const popup = document.createElement("div");
                popup.className =
                    "fixed top-5 right-5 z-50 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slideDown";
                popup.innerHTML = `
                <iconify-icon icon="mdi:check-circle" class="text-xl"></iconify-icon>
                <p>Akun berhasil dibuat! Mengarahkan ke login...</p>
            `;
                document.body.appendChild(popup);

                setTimeout(() => {
                    window.location.href = "{{ route('login.form') }}";
                }, 2000);
            });
        </script>
    @endif


    {{-- 🔥 POPUP NOTIFICATION --}}
    @if ($errors->any())
        <div id="popup"
            class="fixed top-5 right-5 z-50 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slideDown">
            <iconify-icon icon="mdi:alert-circle" class="text-xl"></iconify-icon>
            <div>
                <p class="font-semibold">Validation Error</p>
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

    @if (session('warning'))
        <div id="popup"
            class="fixed top-5 right-5 z-50 bg-yellow-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slideDown">
            <iconify-icon icon="mdi:alert" class="text-xl"></iconify-icon>
            <p>{{ session('warning') }}</p>
            <button onclick="closePopup()" class="ml-3 text-white">
                <iconify-icon icon="mdi:close"></iconify-icon>
            </button>
        </div>
    @endif

    @if (session('info'))
        <div id="popup"
            class="fixed top-5 right-5 z-50 bg-blue-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slideDown">
            <iconify-icon icon="mdi:information" class="text-xl"></iconify-icon>
            <p>{{ session('info') }}</p>
            <button onclick="closePopup()" class="ml-3 text-white">
                <iconify-icon icon="mdi:close"></iconify-icon>
            </button>
        </div>
    @endif

    {{-- CARD FORM --}}

    <div
        class="w-full max-w-md bg-white/90 shadow-xl backdrop-blur-xl rounded-2xl p-8 animate-fadeIn border-blue-400 border-2">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">Create Account ✨</h2>
        <p class="text-center text-gray-500 mb-6">Join Lokavia and get started</p>


        @if ($errors->any())
            <div class="p-3 mb-4 bg-red-100 text-red-700 rounded-md text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf


            <div>
                <label class="block text-gray-700 mb-1 font-medium">Name</label>
                <input type="text" name="username"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Username" required>
            </div>


            <div>
                <label class="block text-gray-700 mb-1 font-medium">Email</label>
                <input type="email" name="email"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="you@example.com" required>
            </div>


            <!-- Password -->
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="••••••••" required>

                    <!-- Eye Icon -->
                    <span data-target="password"
                        class="toggle-eye absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-500">
                        <iconify-icon icon="mdi:eye-off"></iconify-icon>
                    </span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Confirm Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="••••••••" required>

                    <!-- Eye Icon -->
                    <span data-target="password_confirmation"
                        class="toggle-eye absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-500">
                        <iconify-icon icon="mdi:eye-off"></iconify-icon>
                    </span>
                </div>
            </div>

            <script>
                document.querySelectorAll(".toggle-eye").forEach(toggle => {
                    toggle.addEventListener("click", () => {
                        const targetId = toggle.getAttribute("data-target");
                        const input = document.getElementById(targetId);
                        const icon = toggle.querySelector("iconify-icon");

                        const hidden = input.type === "password";

                        input.type = hidden ? "text" : "password";
                        icon.setAttribute("icon", hidden ? "mdi:eye" : "mdi:eye-off");
                    });
                });
            </script>

            <button
                class="w-full py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">Register</button>
        </form>


        <p class="mt-6 text-center text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Login</a>
        </p>

    </div>

    <script>
        function closePopup() {
            const popup = document.getElementById('popup');
            if (popup) popup.remove();
        }

        setTimeout(() => {
            closePopup();
        }, 3000);
    </script>


</body>

</html>
