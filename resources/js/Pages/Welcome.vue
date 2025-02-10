<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <!-- Background image with the container for centering content -->
    <div 
        class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50"
        :style="{ backgroundImage: 'url(/images/img1.png)', backgroundSize: 'cover', backgroundPosition: 'center', height: '100vh' }"
    >
        <!-- Main content container for centering -->
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-lg">
                <!-- Water Billing System Header -->
                <header class="py-10">
                    <h1 class="text-3xl font-bold text-center text-[#FF2D20]">
                        Water Billing System
                    </h1>
                </header>

                <!-- Main content area with Login/Register -->
                <main>
                    <!-- Login/Register Card -->
                    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                            Get Started
                        </h2>
                        <p class="mb-6 text-gray-600 dark:text-gray-300 text-center">
                            Choose an option to log in or register and start using our platform.
                        </p>
                        <div class="flex flex-col gap-4">
                            <Link
                                :href="route('login')"
                                class="w-full rounded-lg bg-[#FF2D20] px-4 py-2 text-center text-white transition hover:bg-[#e5241c] focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#FF2D20]"
                            >
                                Log in
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="w-full rounded-lg bg-gray-100 px-4 py-2 text-center text-black transition hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
                            >
                                Register
                            </Link>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>
