@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card statistik --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Total Artikel</p>
            <p class="text-3xl font-bold text-[#02A6E0] mt-1">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Total Program</p>
            <p class="text-3xl font-bold text-[#02A6E0] mt-1">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Total Donatur</p>
            <p class="text-3xl font-bold text-[#02A6E0] mt-1">0</p>
        </div>

    </div>

@endsection
