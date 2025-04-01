<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import type {Post} from "@/types";
import Container from "@/Components/Container.vue";
import {formatDistance, parseISO} from "date-fns";
import {computed} from "vue";

const {post} = defineProps<{
    post: Post
}>();

const formattedDate = computed(() => {
    return formatDistance(parseISO(post.created_at), new Date());
})
</script>

<template>
    <AppLayout :title="post.title">
        <Container>
            <h1 class="text-2xl font-bold">
                {{ post.title }}
            </h1>

            <span class="block mt-1 text-sm text-gray-600">
                {{ formattedDate }} ago by {{ post.user.name }}
            </span>

            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>
        </Container>
    </AppLayout>
</template>
