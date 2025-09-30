<template>
  <component :is="layout">
    <RouterView />
  </component>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { LAYOUT_AUTH, LAYOUT_DEFAULT } from '@/constants';

const route = useRoute();

const layouts = {
  [LAYOUT_DEFAULT]: DefaultLayout,
  [LAYOUT_AUTH]: AuthLayout,
};

const layout = computed(() => {
  const layoutName = route.meta.layout || LAYOUT_AUTH;
  return layouts[layoutName];
});
</script>