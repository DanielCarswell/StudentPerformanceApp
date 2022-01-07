@extends('layouts.admin')

    @section('content')
        <main class="flex-col bg-indigo-50 w-full ml-4 pr-6">
            <div class="flex justify-between mt-4 space-x-4 s">
            <div class="bg-white w-1/3 rounded-xl shadow-lg flex items-center justify-around">
                <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">534</h1>
                <span class="text-gray-500">Coaches</span>
                </div>
            </div>
            <div class="bg-white w-1/3 rounded-xl shadow-lg flex items-center justify-around">
                <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">9.7k</h1>
                <span class="text-gray-500">Kids</span>
                </div>
            </div>
            <div class="bg-white w-1/3 rounded-xl shadow-lg flex items-center justify-around">
                <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">50 M</h1>
                <span class="text-gray-500">Revenue</span>
                </div>
            </div>
            </div>
            <div class="flex space-x-4">
            <div class="justify-between rounded-xl mt-4 p-4 bg-white shadow-lg">
                <h1 class="text-xl font-bold text-gray-800 mt-4">Today’s Status</h1>
                <div class="flex justify-between space-x-4 text-center mt-6">
                <div class="bg-indigo-50 rounded-xl p-10">
                    <h3>8.7K</h3>
                    <spnan>Total Present</spnan>
                </div>
                <div class="bg-indigo-50 rounded-xl p-10">
                    <h3>99</h3>
                    <spnan>Registrations</spnan>
                </div>
                <div class="bg-indigo-50 rounded-xl p-10">
                    <h3>30</h3>
                    <spnan>Totals Session</spnan>
                </div>
                </div>
            </div>
            <div class="justify-between rounded-xl mt-4 p-4 bg-white shadow-lg">
                <h1 class="text-xl font-bold text-gray-800 mt-4">Today’s Status</h1>
                <div class="flex justify-between space-x-4 text-center mt-6">
                <div class="bg-indigo-50 rounded-xl p-10">
                    <h3>8.7K</h3>
                    <spnan>Total Present</spnan>
                </div>
                <div class="bg-indigo-50 rounded-xl p-10">
                    <h3>99</h3>
                    <spnan>Registrations</spnan>
                </div>
                <div class="bg-indigo-50 rounded-xl p-10">
                    <h3>30</h3>
                    <spnan>Totals Session</spnan>
                </div>
                </div>
            </div>
            </div>
        </main>
    @endsection
