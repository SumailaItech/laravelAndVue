<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <not-found></not-found>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NotFound from './NotFound.vue'
    export default {
  components: { NotFound },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
