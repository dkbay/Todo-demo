<template>
  <fa v-if="loading" size="2x" :style="{color: '#415459'}" :icon="['fas', 'circle-notch']" />
</template>

<script>
import Form from 'vform'

export default {
  name: 'Spinner',

  props: {
    loading: false
  }
}
</script>

<style scoped>
  @-moz-keyframes spin {
    from { -moz-transform: rotate(0deg); }
    to { -moz-transform: rotate(360deg); }
  }
  @-webkit-keyframes spin {
    from { -webkit-transform: rotate(0deg); }
    to { -webkit-transform: rotate(360deg); }
  }
  @keyframes spin {
    from {transform:rotate(0deg);}
    to {transform:rotate(360deg);}
  }

  svg {
    position: fixed;
    top: 75px;
    right: 25px;

    -webkit-animation-name: spin;
    -webkit-animation-duration: 2000ms;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-timing-function: linear;
    -moz-animation-name: spin;
    -moz-animation-duration: 2000ms;
    -moz-animation-iteration-count: infinite;
    -moz-animation-timing-function: linear;

    animation-name: spin;
    animation-duration: 2000ms;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
  }
</style>
