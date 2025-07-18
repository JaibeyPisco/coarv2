<script setup>
import { useRoute, useRouter } from 'vue-router';

const props = defineProps({
    to: String,
    icon: String,
    label: String
})

const route = useRoute();

const router = useRouter();

const handleClick = ()=> {
    if(route.path !== props.to)[
        router.push(props.to)
    ]
}
</script>

<template>
    <li class="nav-item">
      <a href="#" class="nav-link" :class="{ active: route.path === to }" @click.prevent="handleClick">
            <i :class="`nav-icon ${icon}`"></i>
            <p>{{ label }}</p>
        </a>
    </li>
</template>
<style>
</style>