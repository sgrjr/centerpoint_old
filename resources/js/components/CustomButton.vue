<template>
    <button :id={id} :class={classes} :style={styles} :onClick={clickHandler} :disabled={disabled}>
        <Icon :name="startIcon"/>
        <span class="text">{{ text }}</span>
        <Icon :name="endIcon"/>
    </button>
</template>

<style lang="scss">

button {
	font-family:inherit;
	padding:10px;
    margin:0;
    border-radius:0;
    font-size:1em;
    text-align:center;
    vertical-align:middle;
    color:$white;
    border: solid 1px $gray;
    background-color:$gray;
}

button svg {
	margin:0;
}

//default button styles
button.default-contained:hover{
	color:$white;
	background:$blue;
	border:$blue;
}

button.default-outlined:hover{
	color:$gray;
	background:$white;
	border:soldi 1px $gray;
}

//error button styles
button.error-contained {
	color:$white;
	border-color:$white;
	background:$red;
}

button.error-contained:hover {
	color:$red;
	border-color:$red;
	background:$white;
}

button.error-outlined {
	color:$red;
	border-color:$red;
	background:$white;
}

button.error-outlined:hover {
	color:$white;
	border-color:$white;
	background:$red;
}

//primary button styles

button.primary-contained {
	background: $blue;
    color:$white;
    border-color:$blue;
}

button:disabled {
	outline:inherit;
	cursor:no-drop;
	border:none;
}

button.min {
	.text {display:none;}
}
</style>

<script>
import Icon from './Icon'

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return 'button'
      },
    },
    classes: {
      type: String,
      default: '',
    },
    clickHandler: {
      type: Function,
      default: ()=>{},
    },
    disabled:  {
      type: String,
      default: '',
    },
    startIcon: String,
    endIcon: String,
    text: String
  }
}
</script>