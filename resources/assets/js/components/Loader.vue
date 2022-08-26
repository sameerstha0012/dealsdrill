<template>
    <div class="loader">
        <h3 class="text">
            {{ text }}<span class="m-loader m-loader--brand"></span>
        </h3>
    </div>
</template>

<script>

    export default {
        props: [],

        data() {
             return {
                text: 'Please wait...',
             } 
        },
    }
</script>

<style>
.loader {
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.5);
    text-align: center;
    z-index: 999999;
}

.loader h3 {
    font-size: 14px;
    font-weight: 400;
    padding: 10px;
    margin-bottom: 0;
    width: 160px;
    height: 40px;
    margin-top: 30%;
    background-position: center;
    background: white;
    box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);
    color:#575962;
    display: inline-block;
}

.m-loader {
    width: 50px;
    display: inline-block;
}

.m-loader:before {
    margin-top: -13px;
    border-top-width: 3px;
    border-right-width: 3px;
}
</style>