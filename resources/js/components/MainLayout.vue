<template>
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <mbody class="row">
                    <slot name="mbody"></slot>
                </mbody>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "MainLayout"
}
</script>

<style scoped>

</style>
