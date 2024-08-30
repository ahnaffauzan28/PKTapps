<template>
    <Head title="Dashboard" />
    <MainLayout title="Welcome to Dashboard">
        <div> <Welcome class="mt-6" /> 
            <div class="header flex items-center justify-center p-4 mb-6">
            <h1 class="loading-text">FUTURE IS OURS !!!</h1>
        </div>
        </div>
      <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <RevenueStat class="card bg-blue-100 border-l-4 border-orange-500 p-4" />
            <ProductionStat class="card bg-blue-100 border-l-4 border-orange-500 p-4" />
            <ProductionGraph class="card bg-blue-100 border-l-4 border-orange-500 p-4" />
            <ProductionSummary class="card bg-blue-100 border-l-4 border-orange-500 p-4" />
            <ReportNewProduction class="card bg-blue-100 border-l-4 border-orange-500 p-4" />
        </div> --> 
    </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import RevenueStat from '@/Widgets/Home/RevenueStat.vue';
import ProductionStat from '@/Widgets/Home/ProductionStat.vue';
import Welcome from '@/Widgets/Home/Welcome.vue';
import ProductionGraph from '@/Widgets/Home/ProductionGraph.vue';
import ProductionSummary from '@/Widgets/Home/ProductionSummary.vue';
import ReportNewProduction from '@/Widgets/Home/ReportNewProduction.vue';

</script>

<style>
.header {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem; /* Sesuaikan padding sesuai kebutuhan */
    margin-bottom: 1.5rem; /* Sesuaikan margin sesuai kebutuhan */
    background: #ffffff; /* Warna latar belakang dasar */
    overflow: hidden; /* Menghindari overflow */
}

.loading-text {
    color: #ffffff; /* Teks putih */
    font-size: 2rem; /* Ukuran font yang lebih besar */
    font-weight: bold;
    text-shadow: 
        0 0 5px #ff6600, /* Efek glow oranye */
        0 0 10px #ff6600,
        0 0 15px #0000f3, /* Efek glow biru */
        0 0 20px #0000f3,
        0 0 25px #0000f3,;
    animation: loading 1.5s infinite; /* Menambahkan animasi loading */
}

@keyframes loading {
    0% {
        text-shadow: 
            0 0 5px #ff6600,
            0 0 10px #ff6600,
            0 0 15px #0000ff,
            0 0 20px #0000ff,
            0 0 25px #0000ff;
    }
    50% {
        text-shadow: 
            0 0 10px #ff6600,
            0 0 20px #ff6600,
            0 0 30px #0000ff,
            0 0 40px #0000ff,
            0 0 50px #0000ff;
    }
    100% {
        text-shadow: 
            0 0 5px #ff6600,
            0 0 10px #ff6600,
            0 0 15px #0000ff,
            0 0 20px #0000ff,
            0 0 25px #0000ff;
    }
}
</style>
