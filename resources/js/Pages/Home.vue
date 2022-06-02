<template>
    <div>
     <MainNavigation :user="user" :application="application"/>
     <Footer />
    </div>
</template>

<script>
    import MainNavigation from '../components/MainNavigation.vue'
    import Footer from '../components/Footer.vue'

    export default {
        props: {
            application: Object,
            user: Object
        },

        components: {
            MainNavigation,
            Footer
        },

        mounted() {
            console.log('Welcome Component mounted.')
        }
    }
</script>
