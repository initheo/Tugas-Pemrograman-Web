<script setup>
import { watch } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

// Watch for route changes to update title
watch(() => route.meta.title, (title) => {
  document.title = title ? `${title} - LaundrEase Layanan Laundry Modern & Terpercaya` : 'LaundrEase - Layanan Laundry Modern & Terpercaya'
})
</script>

<template>
  <main>
    <router-view />
  </main>
</template>