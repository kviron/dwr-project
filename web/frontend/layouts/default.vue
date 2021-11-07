<template>
  <div>
    <Header />
    <Nuxt />
    <Footer />
  </div>
</template>
<script>
import Header from '../components/header'
import Footer from '../components/footer'

export default {
  components: {
    Header,
    Footer
  }
}
</script>
