@extends('layouts.main')

@section('title', 'Products - TimeBridge')

@section('content')
    <!-- Main Content -->
    <main class="flex-grow pt-8 pb-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <livewire:product-catalog />
        </div>
    </main>
@endsection
