@extends('layouts.admin')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 flex justify-center">
            Application Statistics
        </div>
    </div>
    
    <main class="flex-col bg-indigo-50 w-full ml-4 pr-6">
        <div class="bg-indigo-50 flex justify-between mt-4 mb-12 space-x-4 s">
            <div class="w-1/3 rounded-xl shadow-lg flex items-center justify-around">
                <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">40</h1>
                <span class="text-gray-500">Teachers</span>
                </div>
            </div>
            <div class="w-1/3 rounded-xl shadow-lg flex items-center justify-around">
                <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">300</h1>
                <span class="text-gray-500">Classes</span>
                </div>
            </div>
            <div class="w-1/3 rounded-xl shadow-lg flex items-center justify-around">
                <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">534</h1>
                <span class="text-gray-500">Students</span>
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-4 space-x-4 s">
            <div class=" w-1/3 rounded-xl shadow-lg flex items-center justify-around">
                <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">1300</h1>
                <span class="text-gray-500">Users</span>
                </div>
            </div>
            <div class=" w-1/3 rounded-xl shadow-lg flex items-center justify-around">
                <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">20</h1>
                <span class="text-gray-500">Application Managers</span>
                </div>
            </div>
            <div class=" w-1/3 rounded-xl shadow-lg flex items-center justify-around">
                <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-800">534</h1>
                <span class="text-gray-500">Students</span>
                </div>
            </div>
        </div>
    </main>
@endsection