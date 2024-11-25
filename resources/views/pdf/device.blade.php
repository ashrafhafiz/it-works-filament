<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="p-6 bg-white">
    <!-- Header Section -->
    <div class="pb-4 mb-6 border-b-2 border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <img src="{{ public_path('images/gc3-logo2.png') }}" alt="Company Logo" class="h-16">
            </div>
            <div class="text-right">
                <h1 class="text-2xl font-bold text-gray-800">Device Details</h1>
                <p class="text-gray-600">Generated on: {{ now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Basic Information Section -->
    <div class="mb-8">
        <h2 class="mb-4 text-xl font-semibold text-gray-800">Basic Information</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <div class="flex">
                    <span class="w-32 font-medium">Model:</span>
                    <span>{{ $device->model }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Service Tag:</span>
                    <span>{{ $device->service_tag }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Device Type:</span>
                    <span>{{ $device->deviceType->name }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Manufacturer:</span>
                    <span>{{ $device->manufacturer->name }}</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex">
                    <span class="w-32 font-medium">Status:</span>
                    <span
                        class="px-2 py-1 rounded-full text-sm {{ $device->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($device->status) }}
                    </span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Shipping Date:</span>
                    <span>{{ $device->shipping_date->format('d M Y') }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Employee:</span>
                    <span>{{ $device->employee?->full_name ?? 'Unassigned' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hardware Specifications -->
    <div class="mb-8">
        <h2 class="mb-4 text-xl font-semibold text-gray-800">Hardware Specifications</h2>
        <div class="p-4 rounded-lg bg-gray-50">
            <div class="grid grid-cols-2 gap-4">
                <!-- Processing & Memory -->
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 font-medium">Processor:</span>
                        <span>{{ $device->processor_type }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 font-medium">Memory:</span>
                        <span>{{ $device->memory_size }} GB</span>
                    </div>
                </div>

                <!-- Storage -->
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 font-medium">Primary Storage:</span>
                        <span>{{ $device->storage1_size }} GB</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 font-medium">Secondary Storage:</span>
                        <span>{{ $device->storage2_size ?? 'N/A' }} GB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphics & Display -->
    <div class="mb-8">
        <h2 class="mb-4 text-xl font-semibold text-gray-800">Graphics & Display</h2>
        <div class="p-4 rounded-lg bg-gray-50">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 font-medium">Primary Graphics:</span>
                        <span>{{ $device->graphics_1 }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 font-medium">Secondary Graphics:</span>
                        <span>{{ $device->graphics_2 ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 font-medium">Display:</span>
                        <span>{{ $device->display }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 font-medium">Sound:</span>
                        <span>{{ $device->sound }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Connectivity -->
    <div class="mb-8">
        <h2 class="mb-4 text-xl font-semibold text-gray-800">Connectivity</h2>
        <div class="p-4 rounded-lg bg-gray-50">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 font-medium">Ethernet:</span>
                        <span>{{ $device->ethernet }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 font-medium">Wireless:</span>
                        <span>{{ $device->wireless }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="fixed bottom-0 left-0 right-0 p-4 text-sm text-center text-gray-500">
        <p>This document is confidential and intended for internal use only.</p>
        <p>Generated by IT Asset Management System - Page 1 of 1</p>
    </div>
</body>

</html>
