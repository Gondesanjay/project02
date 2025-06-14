<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Ujian</h1>
            <p class="text-gray-600">Tambah, edit, dan kelola jadwal ujian Anda</p>
        </div>
        <button wire:click="toggleForm" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
            {{ $showForm ? 'Batal' : '+ Tambah Ujian' }}
        </button>
    </div>

    @if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('message') }}
    </div>
    @endif

    <!-- Form Tambah/Edit -->
    @if($showForm)
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">{{ $editingId ? 'Edit Ujian' : 'Tambah Ujian Baru' }}</h2>

        <form wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran/Ujian</label>
                    <input type="text" wire:model="subject" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Matematika">
                    @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" wire:model="exam_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('exam_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                        <input type="time" wire:model="exam_time" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('exam_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                <textarea wire:model="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Catatan tambahan tentang ujian"></textarea>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    {{ $editingId ? 'Perbarui' : 'Simpan' }}
                </button>
                <button type="button" wire:click="toggleForm" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Daftar Ujian -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Daftar Ujian</h2>

            @if($exams->count() > 0)
            <div class="space-y-4">
                @foreach($exams as $exam)
                <div class="border rounded-lg p-4 {{ $exam->status === 'completed' ? 'bg-green-50 border-green-200' : ($exam->days_until_exam < 0 ? 'bg-red-50 border-red-200' : 'border-gray-200') }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-grow">
                            <div class="flex items-center space-x-2 mb-2">
                                <h3 class="font-semibold text-gray-800 {{ $exam->status === 'completed' ? 'line-through' : '' }}">
                                    {{ $exam->subject }}
                                </h3>
                                <span class="px-2 py-1 text-xs rounded-full {{ 
                                        $exam->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                        ($exam->days_until_exam < 0 ? 'bg-red-100 text-red-800' : 
                                        ($exam->days_until_exam <= 3 ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800'))
                                    }}">
                                    {{ $exam->status === 'completed' ? 'Selesai' : ($exam->days_until_exam < 0 ? 'Terlewat' : $exam->days_until_exam . ' hari lagi') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">{{ $exam->formatted_exam_date }}</p>
                            @if($exam->description)
                            <p class="text-sm text-gray-500">{{ $exam->description }}</p>
                            @endif
                        </div>

                        <div class="flex space-x-2 ml-4">
                            @if($exam->status !== 'completed' && $exam->days_until_exam >= 0)
                            <button wire:click="markCompleted({{ $exam->id }})" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                ✓ Selesai
                            </button>
                            @endif
                            <button wire:click="edit({{ $exam->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Edit
                            </button>
                            <button wire:click="delete({{ $exam->id }})" onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500">Belum ada ujian yang ditambahkan</p>
                <button wire:click="toggleForm" class="mt-2 text-blue-500 hover:text-blue-600 font-medium">
                    Tambah ujian pertama Anda
                </button>
            </div>
            @endif
        </div>
    </div>
</div>