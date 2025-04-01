<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";

interface Post {
    id: number;
    user_id: number;
    title: string;
    body: string;
    created_at: string;
    updated_at: string;
}

defineProps<{
    posts: Post[]
}>()
</script>

<template>
    <AppLayout>
        <ul>
            <li v-for="post in posts" :key="post.id">
                {{ post.title }}
            </li>
        </ul>
    </AppLayout>
</template>
