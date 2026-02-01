@extends('layouts.main')

@section('title', 'Shopping Cart - TimeBridge')
@section('body-class', 'bg-gray-50')

@section('content')
    <!-- Main Content -->
    <main class="flex-grow pt-12 pb-12">
        <div class="max-w-7xl mx-auto px-6">
            <livewire:cart-manager />
        </div>
    </main>
@endsection
