{{-- Menampilkan pesan sukses / error / validasi. Pakai: <x-flash /> --}}
@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 text-center font-semibold border border-green-200 text-sm">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 text-center font-semibold border border-red-200 text-sm">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-200 text-sm">
    <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
