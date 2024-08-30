<template>
    <div class="p-4 rounded-xl border border-gray-400 flex-1 bg-white shadow-md">
        <div class="flex justify-between items-center flex-wrap gap-3">
            <div class="flex items-center gap-3 flex-wrap justify-center">
                <BsProfilePicture :npk="npk" class="rounded-full w-12 h-12" />
                <div class="text-center sm:text-left">
                    <h1 class="font-bold text-lg">Welcome,</h1>
                    <p class="font-light text-sm">{{ name }}</p>
                    <p class="text-xs text-gray-500">{{ currentDateTime }}</p>
                </div>
            </div>

            <BsButton @click="logout" class="w-full sm:w-fit" type="primary-outline" icon="arrow-left-on-rectangle">
                Logout
            </BsButton>
        </div>

        <div class="mt-4 text-center">
            <p class="font-medium">Here's a motivational quote to start your day:</p>
            <blockquote class="italic text-sm text-gray-600 mt-2">{{ quote }}</blockquote>
        </div>
    </div>
</template>

<script setup>
import BsButton from '@/Components/BsButton.vue';
import BsProfilePicture from '@/Components/BsProfilePicture.vue';
import { router, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const npk = usePage().props.auth.user.npk;
const name = usePage().props.auth.user.name;

const logout = () => {
    router.post(route('logout'));
};

const currentDateTime = ref('');
const quote = ref('');

const updateDateTime = () => {
    const now = new Date();
    currentDateTime.value = now.toLocaleString();
};

const fetchQuote = async () => {
    try {
        const response = await fetch('https://api.quotable.io/random');
        const data = await response.json();
        quote.value = data.content;
    } catch (error) {
        quote.value = "Keep pushing forward!";
    }
};

onMounted(() => {
    updateDateTime();
    fetchQuote();
    setInterval(updateDateTime, 1000);
});

</script>

<style scoped>
.bg-white {
    background-color: #ffffff;
}
.shadow-md {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
