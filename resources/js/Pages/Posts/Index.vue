<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from '@inertiajs/vue3'

import type {PaginatedData, Post} from "@/types";
import {computed} from "vue";
import {formatDistance, parseISO} from "date-fns";

defineProps<{
    posts: PaginatedData<Post>
}>();

const formattedDate = (post: Post) => {
    return formatDistance(parseISO(post.created_at), new Date());
};
</script>

<template>
    <AppLayout>
        <Container>
            <ul class="divide-y">
                <li v-for="post in posts.data" :key="post.id">
                    <Link :href="route('posts.show', post.id)" class="group px-2 py-4 block">
                        <span class="font-bold text-lg group-hover:text-indigo-500 transition-colors">
                            {{ post.title }}
                        </span>

                        <span class="block mt-1 text-sm text-gray-600">
                            {{ formattedDate(post) }} ago by {{ post.user.name }}
                        </span>
                    </Link>
                </li>
            </ul>

            <Pagination :meta="posts.meta" />
        </Container>
    </AppLayout>
</template>
