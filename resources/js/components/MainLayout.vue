<template>
    <div class="main-content">
        <div class="section__content section__content--p10">
            <div class="container-fluid">
                <mbody>
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
.main-content{
    padding-top: 95px;
}
</style>
