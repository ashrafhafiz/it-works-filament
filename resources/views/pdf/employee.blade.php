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
                <h1 class="text-2xl font-bold text-gray-800">Employee Details</h1>
                <p class="text-gray-600">Generated on: {{ now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Personal Information Section -->
    <div class="mb-8">
        <h2 class="mb-4 text-xl font-semibold text-gray-800">Personal Information</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <div class="flex">
                    <span class="w-32 font-medium">Employee ID:</span>
                    <span>{{ $employee->employee_no }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Name (en):</span>
                    <span>{{ $employee->name_en }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Name (عربي):</span>
                    <span>{{ $employee->name_ar }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Department:</span>
                    <span>{{ $employee->department->name }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Job Title:</span>
                    <span>{{ $employee->job_title }}</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex">
                    <span class="w-32 font-medium">Join Date:</span>
                    <span>{{ $employee->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Email:</span>
                    <span>{{ $employee->email }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Phone:</span>
                    <span>{{ $employee->mobiles[0]->mobile_no }}</span>
                </div>
                <div class="flex">
                    <span class="w-32 font-medium">Status:</span>
                    <span
                        class="px-2 py-1 rounded-full text-sm {{ $employee->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($employee->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Employment Details Section -->
    <div class="mb-8">
        <h2 class="mb-4 text-xl font-semibold text-gray-800">Employment Details</h2>
        <div class="p-4 rounded-lg bg-gray-50">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 font-medium">National ID:</span>
                        <span>{{ $employee->national_id }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 font-medium">Manager:</span>
                        <span>{{ $employee->manager?->name_ar ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 font-medium">Work Location:</span>
                        <span>{{ $employee->location->name }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 font-medium">Sector:</span>
                        <span>{{ $employee->sector->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Emergency Contact Section -->
    @if ($employee->emergency_contact)
        <div class="mb-8">
            <h2 class="mb-4 text-xl font-semibold text-gray-800">Emergency Contact</h2>
            <div class="p-4 rounded-lg bg-gray-50">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="w-32 font-medium">Name:</span>
                            <span>{{ $employee->emergency_contact->name }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 font-medium">Relationship:</span>
                            <span>{{ $employee->emergency_contact->relationship }}</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="w-32 font-medium">Phone:</span>
                            <span>{{ $employee->emergency_contact->phone }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 font-medium">Email:</span>
                            <span>{{ $employee->emergency_contact->email ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Footer Section -->
    <div class="fixed bottom-0 left-0 right-0 p-4 text-sm text-center text-gray-500">
        <p>This document is confidential and intended for internal use only.</p>
        <p>Generated by HR Management System - Page 1 of 1</p>
    </div>
</body>

</html>
