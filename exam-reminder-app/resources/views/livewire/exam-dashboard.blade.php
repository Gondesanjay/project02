<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Pengingat Ujian</h1>
        <p class="text-gray-600">Kelola jadwal ujian Anda dengan efektif</p>
    </div>

    <!-- Alert Ujian Mendesak -->
    @if($urgentExams->count() > 0)
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            <strong>Peringatan!</strong> Anda memiliki {{ $urgentExams->count() }} ujian dalam 7 hari ke depan.
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Ujian Mendatang -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Ujian Mendatang</h2>

                @if($upcomingExams->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingExams as $exam)
                    <div class="border-l-4 {{ $exam->days_until_exam <= 3 ? 'border-red-500 bg-red-50' : ($exam->days_until_exam <= 7 ? 'border-yellow-500 bg-yellow-50' : 'border-blue-500 bg-blue-50') }} p-4 rounded-r-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $exam->subject }}</h3>
                                <p class="text-sm text-gray-600">{{ $exam->formatted_exam_date }}</p>
                                @if($exam->description)
                                <p class="text-sm text-gray-500 mt-1">{{ $exam->description }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-medium {{ $exam->days_until_exam <= 3 ? 'text-red-600' : ($exam->days_until_exam <= 7 ? 'text-yellow-600' : 'text-blue-600') }}">
                                    {{ $exam->days_until_exam >= 0 ? $exam->days_until_exam . ' hari lagi' : 'Terlewat' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500">Belum ada ujian yang dijadwalkan</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Tips Belajar Hari Ini -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">💡 Tips Belajar Hari Ini</h2>
                @if($todayTip)
                <div>
                    <span class="inline-block bg-white bg-opacity-20 rounded-full px-3 py-1 text-sm font-medium mb-2">
                        {{ $todayTip->category }}
                    </span>
                    <p class="text-sm leading-relaxed">{{ $todayTip->tip }}</p>
                </div>
                @endif
                <button wire:click="loadData" class="mt-4 bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded text-sm font-medium transition-colors">
                    Tips Lain
                </button>
            </div>

            <!-- Statistik -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Statistik</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Ujian Mendatang</span>
                        <span class="font-semibold text-blue-600">{{ $upcomingExams->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ujian Mendesak</span>
                        <span class="font-semibold text-red-600">{{ $urgentExams->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>