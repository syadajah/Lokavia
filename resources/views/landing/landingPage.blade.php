<!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lokavia — Rental Mobil</title>

            {{-- Font Poppins --}}
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
            {{-- <link href="https://fonts.googleapis.com/css2?family=Comic+Relief:wght@400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> --}}

            {{-- Tailwind via Vite --}}
            @vite('resources/css/app.css')

            <style>
                html {
                    scroll-behavior: smooth; /* <<< membuat perpindahan halus */
                }

                body {
                    font-family: 'Poppins', sans-serif;
                }

                a, button {
                    @apply transition-all duration-300;
                }
            </style>

            {{-- Iconify --}}
            <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
        </head>

        <body class="bg-white text-gray-800">

            {{-- Navbar --}}
            <nav class="w-full fixed top-0 left-0 bg-white/80 backdrop-blur-md shadow-sm z-50">
                <div class="container mx-auto flex items-center justify-between py-4 px-4">

                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/Logo-Lokavia.png') }}" alt="Logo" style="width: 60px; height: auto;">
                        <h2 style="font-size: 20px; font-weight: bold;">Lokavia</h2>
                    </div>

                    <div class="hidden md:flex gap-6 text-sm font-medium">
                        <a href="#how" class="hover:text-blue-600">How it works</a>
                        <a href="#deals" class="hover:text-blue-600">Rental deals</a>
                        <a href="#why" class="hover:text-blue-600">Why choose us</a>
                    </div>

                    <div class="flex gap-3 text-sm font-medium">
                        <a href="{{ route('login') }}" class="px-5 py-2 hover:text-blue-600">Sign In</a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Sign Up</a>
                    </div>
                </div>
            </nav>

            {{-- Hero Section --}}
            <section class="container mx-auto px-4 pt-32 pb-40 flex flex-col md:flex-row items-center">
                <div class="md:w-1/2">
                    <h2 class="text-4xl md:text-5xl font-bold leading-tight">
                        Find, book and rent a car <span class="text-blue-600">Easily</span>
                    </h2>
                    <p class="mt-5 text-gray-600 text-lg">
                        Get a car wherever and whenever you need it with <b>Lokavia</b> — available only in <b>Lokavia</b>
                        Website.
                    </p>
                    <a href="#deals" class="mt-8 inline-block bg-blue-600 text-white px-7 py-3 rounded-lg hover:bg-blue-700">
                        Get Started
                    </a>
                </div>

                <div class="md:w-1/2 mt-10 md:mt-0 flex justify-center relative">
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1200"
                        class="rounded-3xl w-11/12 shadow-xl" alt="Car Hero">
                </div>
            </section>

            {{-- HOW IT WORKS --}}
            <section id="how" class="py-10 text-center">
                <a class="px-4 py-1 bg-blue-100 text-blue-600 text-sm rounded-full font-medium">HOW IT WORK</a>

                <h3 class="text-3xl font-semibold mt-6">Rent with following 3 working steps</h3>

                <div class="grid md:grid-cols-3 gap-10 mt-12 container mx-auto px-6">

                    <div class="text-center">
                        <span class="iconify text-5xl text-blue-600 mx-auto block"
                            data-icon="mdi:map-marker-radius-outline"></span>
                        <h4 class="font-semibold text-lg mt-4">Choose Location</h4>
                        <p class="text-gray-600 mt-2">Choose your city and find your best car.</p>
                    </div>

                    <div class="text-center">
                        <span class="iconify text-5xl text-blue-600 mx-auto block"
                            data-icon="mdi:calendar-month-outline"></span>
                        <h4 class="font-semibold text-lg mt-4">Pick-up date</h4>
                        <p class="text-gray-600 mt-2">Select pick-up date and time to book your car.</p>
                    </div>

                    <div class="text-center">
                        <span class="iconify text-5xl text-blue-600 mx-auto block" data-icon="mdi:car-key"></span>
                        <h4 class="font-semibold text-lg mt-4">Book your car</h4>
                        <p class="text-gray-600 mt-2">We will deliver it directly to you.</p>
                    </div>

                </div>
            </section>


            {{-- BRAND LOGOS --}}
            <section class="py-14">
                <div class="flex justify-center gap-10 opacity-60 flex-wrap text-xl">
                    <span>HONDA</span>
                    <span>JAGUAR</span>
                    <span>NISSAN</span>
                    <span>VOLVO</span>
                    <span>AUDI</span>
                    <span>ACURA</span>
                </div>
            </section>

            {{-- WHY CHOOSE US --}}
            <section id="why" class="py-20 bg-gray-50">
                <div class="container mx-auto grid md:grid-cols-2 items-center gap-14 px-6">

                    <img src="https://images.unsplash.com/photo-1619767886558-efdc30746de5?q=80&w=1100"
                        class="rounded-3xl shadow-lg" alt="Luxury Car">

                    <div>
                        <a class="px-4 py-1 bg-blue-100 text-blue-600 text-sm rounded-full font-medium">WHY CHOOSE US</a>

                        <h3 class="text-3xl font-semibold mt-5 leading-snug">
                            We offer the best experience<br> with our rental deals
                        </h3>

                        <ul class="mt-6 space-y-4">
                            <li class="flex gap-3">
                                <span class="iconify text-blue-600 text-2xl" data-icon="mdi:shield-check"></span>
                                <p><span class="font-semibold">Best price guaranteed</span><br>Find a lower price? We’ll refund
                                    you.</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="iconify text-blue-600 text-2xl" data-icon="mdi:account"></span>
                                <p><span class="font-semibold">Experience driver</span><br>Need a driver? We have many
                                    professionals.</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="iconify text-blue-600 text-2xl" data-icon="mdi:clock-time-four-outline"></span>
                                <p><span class="font-semibold">24 hour delivery</span><br>Book anytime, delivered anytime.</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="iconify text-blue-600 text-2xl" data-icon="mdi:tools"></span>
                                <p><span class="font-semibold">24/7 support</span><br>Got questions? Our support is here.</p>
                            </li>
                        </ul>
                    </div>

                </div>
            </section>

            {{-- POPULAR RENTAL DEALS --}}
            <section id="deals" class="py-20">
                <h3 class="text-3xl font-semibold text-center">Most popular cars rental deals</h3>

                <div class="grid md:grid-cols-4 gap-8 mt-12 container mx-auto px-6">

                    {{-- Card --}}
                    @php
                        $cars = [
                            [
                                'name' => 'Jaguar XE L P250',
                                'price' => 1800,
                                'img' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=800',
                            ],
                            [
                                'name' => 'Audi R8',
                                'price' => 2100,
                                'img' => 'https://images.unsplash.com/photo-1619767886558-efdc30746de5?q=80&w=800',
                            ],
                            [
                                'name' => 'BMW M3',
                                'price' => 1600,
                                'img' => 'https://images.unsplash.com/photo-1525609004556-c46c7d6cf023?q=80&w=800',
                            ],
                            [
                                'name' => 'Lamborghini Huracan',
                                'price' => 2300,
                                'img' => 'https://images.unsplash.com/photo-1511396274084-0acb0eac07b2?q=80&w=800',
                            ],
                        ];
                    @endphp

                    @foreach ($cars as $car)
                        <div class="bg-white rounded-xl shadow p-5 hover:shadow-lg transition flex flex-col">

                            {{-- FIXED HEIGHT IMAGE --}}
                            <div class="w-full h-48">
                                <img src="{{ $car['img'] }}" class="w-full h-full object-cover rounded-lg"
                                    alt="{{ $car['name'] }}">
                            </div>

                            {{-- TEXT --}}
                            <h4 class="mt-4 font-semibold text-lg">{{ $car['name'] }}</h4>
                            <p class="text-gray-600 text-sm mt-1">
                                Price <span class="font-semibold text-blue-600">${{ $car['price'] }}/day</span>
                            </p>

                            {{-- BUTTON (rata bawah dengan mt-auto) --}}
                            <a href="#"
                                class="mt-auto w-full inline-block bg-blue-600 text-center text-white py-2 rounded-md hover:bg-blue-700 transition-all duration-300">
                                Rent Now →
                            </a>
                        </div>
                    @endforeach


                </div>

                <div class="text-center mt-12">
                    <button class="px-8 py-2 border rounded-md hover:bg-gray-100">Show all vehicles</button>
                </div>
            </section>

            {{-- FOOTER --}}
            <footer class="py-12 bg-gray-900 text-gray-300 mt-10">
                <div class="container mx-auto grid md:grid-cols-4 gap-10 px-6">

                    <div>
                        <h4 class="text-xl font-semibold text-white flex items-center gap-2">
                            <span class="iconify text-2xl text-blue-500" data-icon="mdi:car"></span>
                            Lokavia
                        </h4>
                        <p class="mt-4 text-sm">© 2025 Lokavia. All rights reserved.</p>
                    </div>

                    <div>
                        <h5 class="font-semibold text-white mb-3">Our Product</h5>
                        <ul class="space-y-2 text-sm">
                            <li>Car</li>
                            <li>Packages</li>
                            <li>Features</li>
                            <li>Pricing</li>
                        </ul>
                    </div>

                    <div>
                        <h5 class="font-semibold text-white mb-3">Resources</h5>
                        <ul class="space-y-2 text-sm">
                            <li>Help Center</li>
                            <li>Guides</li>
                            <li>Developer</li>
                            <li>Download</li>
                        </ul>
                    </div>

                    <div>
                        <h5 class="font-semibold text-white mb-3">Follow Us</h5>
                        <div class="flex gap-4 text-xl">
                            <span class="iconify" data-icon="mdi:facebook"></span>
                            <span class="iconify" data-icon="mdi:instagram"></span>
                            <span class="iconify" data-icon="mdi:twitter"></span>
                        </div>
                    </div>

                </div>
            </footer>

        </body>

</html>
