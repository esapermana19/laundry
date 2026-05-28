<?php
// Inisialisasi variabel untuk penanganan simulasi login PHP
$loginMessage = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');

    // Validasi login sederhana
    if (!empty($username) && !empty($password)) {
        $loginMessage = "Selamat datang kembali, " . $username . "! Login berhasil disimulasikan.";
        $messageType = "success";
    } else {
        $loginMessage = "Username dan kata sandi wajib diisi.";
        $messageType = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KlinWash Laundry Services</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                brand: {
                  DEFAULT: '#0081C9', // Biru kustom dari referensi Anda
                  hover: '#006da8',
                  light: '#e6f2fa'
                }
              }
            }
          }
        }
    </script>

    <style>
        /* Desain Masking Potongan Diagonal Chevron yang sangat presisi sesuai gambar referensi Spark */
        @media (min-width: 1024px) {
            .angled-left-panel {
                clip-path: polygon(0 0, 56% 0, 71% 60%, 53% 100%, 0 100%);
            }
        }
        @media (min-width: 768px) and (max-width: 1023px) {
            .angled-left-panel {
                clip-path: polygon(0 0, 65% 0, 80% 60%, 62% 100%, 0 100%);
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-0 md:p-6 font-sans overflow-x-hidden">

    <!-- Kontainer Utama (Card Wrapper Besar) -->
    <div class="w-full max-w-[1080px] h-screen md:h-[520px] bg-white md:rounded-[2.5rem] md:shadow-[0_25px_60px_-15px_rgba(0,0,0,0.15)] overflow-hidden relative flex flex-col md:flex-row">

        <!-- ================= BACKGROUND GAMBAR FULL (Sisi Kanan) ================= -->
        <div class="absolute inset-0 z-0 w-full h-full">
            <img
                src="{{ asset('assets/bg3.jpg')}}"
                alt="KlinWash Laundry Illustration"
                class="w-full h-full object-cover object-center"
                onerror="this.src='pexels-equalstock-31251590.jpg';"
            />
            <!-- Overlay gelap tipis agar ilustrasi menyatu elegan dengan bagian login -->
            <div class="absolute inset-0 bg-blue-900/10 mix-blend-multiply"></div>
        </div>

        <!-- ================= SISI KIRI: PANEL FORM LOGIN (Putih dengan Potongan Chevron) ================= -->
        <div class="w-full lg:w-[100%] md:w-[100%] bg-white md:bg-white/95 lg:bg-white h-full flex flex-col justify-between p-8 sm:p-12 md:p-16 z-10 angled-left-panel relative">

            <!-- Logo KlinWash di Kiri Atas -->
            <div class="flex items-center gap-3">
                <div class="p-2 bg-brand rounded-lg text-white shadow-md shadow-brand/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12c0-3.3 2.7-6 6-6h.1c1.4 0 2.7.5 3.8 1.4L15 9.5c1.1.9 2.4 1.4 3.8 1.4H19c3.3 0 6 2.7 6 6s-2.7 6-6 6h-.1c-1.4 0-2.7-.5-3.8-1.4L13 19.5c-1.1-.9-2.4-1.4-3.8-1.4H9c-3.3 0-6-2.7-6-6z" opacity="0.3"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12c0-1.65 1.35-3 3-3h.1c.7 0 1.35.25 1.9.7l1.1.85c1.1.9 2.4 1.4 3.8 1.4H15c1.65 0 3 1.35 3 3s-1.35 3-3 3h-.1c-.7 0-1.35-.25-1.9-.7l-1.1-.85c-1.1-.9-2.4-1.4-3.8-1.4H6c-1.65 0-3-1.35-3-3z"></path>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-extrabold tracking-wider text-gray-800 leading-none">
                        JACUSA<span class="text-brand">LAUNDRY</span>
                    </span>
                    <span class="text-[8px] text-gray-400 tracking-widest uppercase font-bold mt-1">
                        Laundry Services
                    </span>
                </div>
            </div>

            <!-- Formulir Utama -->
            <div class="my-auto max-w-[360px] w-full pt-8 pb-6 md:py-0">
                {{-- <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight mb-2">
                    Jasa Cuci Esa Laundry System
                </h1> --}}
                <p class="text-gray-400 text-sm mb-8 font-medium">
                    Selamat Datang Kembali, silakan masuk ke akun Anda
                </p>

                <!-- Notifikasi Respons PHP -->
                <?php if(!empty($loginMessage)): ?>
                    <div class="p-3 mb-6 text-xs rounded-xl flex items-center justify-between <?= $messageType === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' ?>">
                        <span class="font-semibold"><?= $loginMessage ?></span>
                        <button onclick="this.parentElement.style.display='none'" class="font-bold ml-2 text-lg hover:opacity-75 focus:outline-none">&times;</button>
                    </div>
                <?php endif; ?>

                <form action="{{ route('proseslogin') }}" method="POST" class="space-y-5">

                    <!-- Input Email/Username -->
                    <div>
                        <label for="email" class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">
                            Email address
                        </label>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            placeholder="username@jacusa.com"
                            required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition-all placeholder:text-gray-300 text-gray-700 text-sm font-medium"
                        />
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••••••"
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition-all pr-12 placeholder:text-gray-300 text-gray-700 text-sm"
                            />
                            <!-- Tombol Toggle Show/Hide Password -->
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                            >
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Ingat Saya & Lupa Password -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-brand focus:ring-brand accent-brand" />
                            <span class="text-xs text-gray-400 font-semibold">Remember me</span>
                        </label>
                        <a href="#" class="text-xs font-bold text-gray-500 hover:text-brand transition-colors">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Tombol Login (Aksen Warna Biru Brand) -->
                    <button
                        type="submit"
                        class="w-32 text-white font-bold py-3 rounded-lg bg-brand hover:bg-brand-hover transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg hover:shadow-brand/20 active:translate-y-0 active:scale-95 text-xs tracking-wider"
                    >
                        LOGIN
                    </button>

                </form>
            </div>

        </div>

        <!-- ================= SISI KANAN: BRANDING LOGO MENGAMBANG (Hanya Layar PC/Tablet) ================= -->
        <div class="hidden md:flex md:absolute md:right-12 lg:right-24 md:top-1/2 md:-translate-y-1/2 z-20 flex-col items-center justify-center text-center">

            <!-- Logo Ikon KlinWash Putih (Meniru gaya Spark) -->
            <div class="mb-4 p-5 bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 shadow-2xl animate-pulse">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12c0-3.3 2.7-6 6-6h.1c1.4 0 2.7.5 3.8 1.4L15 9.5c1.1.9 2.4 1.4 3.8 1.4H19c3.3 0 6 2.7 6 6s-2.7 6-6 6h-.1c-1.4 0-2.7-.5-3.8-1.4L13 19.5c-1.1-.9-2.4-1.4-3.8-1.4H9c-3.3 0-6-2.7-6-6z" opacity="0.3"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12c0-1.65 1.35-3 3-3h.1c.7 0 1.35.25 1.9.7l1.1.85c1.1.9 2.4 1.4 3.8 1.4H15c1.65 0 3 1.35 3 3s-1.35 3-3 3h-.1c-.7 0-1.35-.25-1.9-.7l-1.1-.85c-1.1-.9-2.4-1.4-3.8-1.4H6c-1.65 0-3-1.35-3-3z"></path>
                </svg>
            </div>

            <!-- Nama Brand Putih Berukuran Besar dengan Bayangan -->
            <h2 class="text-4xl font-extrabold text-white tracking-widest drop-shadow-[0_4px_8px_rgba(0,0,0,0.3)]">
                Jacusa
            </h2>
            <p class="text-xs text-white/90 font-bold uppercase tracking-widest mt-1.5 drop-shadow">
                Laundry Services
            </p>
        </div>

    </div>

    <!-- Script JavaScript untuk Toggle Show/Hide Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                // Toggle Ikon Mata Menggunakan Path SVG
                if (isPassword) {
                    // Tampilan Mata Dicoret / Tersembunyi
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                    `;
                } else {
                    // Tampilan Mata Normal / Terlihat
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    `;
                }
            });
        });
    </script>
</body>
</html>
