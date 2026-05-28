<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan - YON RESTO</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,600,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            orange: '#f5a623',
                            yellow: '#f8c23a',
                            green: '#7ed321',
                            cream: '#fcfaf2'
                        }
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-cream font-sans min-h-screen flex items-center justify-center p-6 text-gray-800">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl shadow-brand-yellow/10 text-center border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-brand-orange via-brand-yellow to-brand-green"></div>
        <span class="text-8xl block mb-6 animate-bounce">🍽️</span>
        <h1 class="text-6xl font-black text-brand-orange tracking-tight mb-2">404</h1>
        <h2 class="text-xl font-bold text-gray-900 mb-4">Waduh! Menu atau Halaman Tidak Ditemukan</h2>
        <p class="text-gray-500 text-sm leading-relaxed mb-8">Maaf, halaman yang Anda cari tidak ada atau mungkin telah dipindahkan oleh koki kami.</p>
        
        <a href="/" class="inline-flex items-center justify-center px-6 py-3 bg-brand-green hover:bg-green-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-brand-green/30 transition-all hover:-translate-y-0.5 active:translate-y-0">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
