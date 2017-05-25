<template>
  <ul id="entry">
    <li class="entry-component entry-up entry-note">
      <router-link to="note" class="entry-router">记</router-link>
    </li>
    <li class="entry-component entry-down entry-read">
      <router-link to="read" class="entry-router">阅</router-link>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'entry'
}
</script>

<style>
  ul#entry{
    margin: 0; padding: 0;
    list-style: none;
    height: 100%; width: 100%;
  }
  li.entry-component{
    display: flex;
    height: 50%; width: 100%;
    text-align: center;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  a.entry-router{
    color: white;
    font-size: 5em;
    text-decoration: none;

    display: block;
    width: calc( 1em + 1em ); height: calc( 1em + 1em );
    line-height: calc( 1em + 1em );

    border-radius: 50%;
  }
  a.entry-router:active{
    color: white;
  }
  .entry-note a.entry-router{
    background-color: #67D5B5;
  }
  .entry-read a.entry-router{
    background-color: #84B1ED;
  }

</style>
