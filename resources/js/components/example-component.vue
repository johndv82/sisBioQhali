<template>
    <MainLayout>
        <template #mbody>
            <div>Hello, Example Component!</div>
        </template>
    </MainLayout>
</template>

<script lang="js">
import MainLayout from "./MainLayout";

export default {
    components: {MainLayout},
    mounted() {
        console.log('Example component mounted.')
    }
}
</script>
