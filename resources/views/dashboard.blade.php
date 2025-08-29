@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <!-- Placeholder for content -->
                <div class="absolute inset-0 size-full flex items-center justify-center text-gray-400">Box 1</div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <!-- Placeholder for content -->
                <div class="absolute inset-0 size-full flex items-center justify-center text-gray-400">Box 2</div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <!-- Placeholder for content -->
                <div class="absolute inset-0 size-full flex items-center justify-center text-gray-400">Box 3</div>
            </div>
        </div>
        <div class="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
            <!-- Placeholder for content -->
            <div class="absolute inset-0 size-full flex items-center justify-center text-gray-400">Main Content Area</div>
        </div>
    </div>
@endsection
