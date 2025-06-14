<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pengingat Ujian' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body class="bg-gray-50">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold">📚 Pengingat Ujian</h1>
                </div>
                <div class="flex space-x-6">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-200 transition-colors {{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('exams') }}" class="hover:text-blue-200 transition-colors {{ request()->routeIs('exams') ? 'font-semibold' : '' }}">
                        Kelola Ujian
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>