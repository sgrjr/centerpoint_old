<template>
<footer class="main-footer">
   
      <section>
        <ul>
          <li>CENTER POINT LARGE PRINT INC.</li>
          <li>LARGE PRINT PUBLISHER</li>
          <li>600 BROOKS ROAD</li>
          <li>KNOX, MAINE 04986</li>
          <li>TOLL FREE: 1-800-929-9108</li>
          <li>FAX: 1-207-568-3727</li>
        </ul>
        <ul>
          <li><a href="#"><Icon name="right-arrow"></Icon>Shop</a></li>
          <li><a href="#"><Icon name="right-arrow"></Icon>FAQ</a></li>
          <li><a href="#"><Icon name="right-arrow"></Icon>Shipping &amp; Returns</a></li>
          <li><a href="#"><Icon name="right-arrow"></Icon>Payment Methods</a></li>
        </ul>
      </section>

      <section><p>© 2022 by CENTER POINT LARGE PRINT</p>
      <button color="error" class="noPrint" onClick={loginAdmin()}>! for development only: login asADMIN !</button>
              </section>
    </footer>
</template>

<style lang="scss">
footer.main-footer
{
	background-color:$blue;
	color: white;
	font-size:1.25rem;
	padding-left:30%;
	margin-top:60px;

	a, a:visited {
		color:white;
		padding:10px;
    text-decoration: none;

    svg {
      fill:$white;
      height:32px;
      vertical-align:middle;
    }
	}

	a:hover{
		text-decoration:underline;
	}

	section {
		display:flex;
	}

	ul {
		list-style:none;
	}

}

@media(max-width:1199px){
	footer.main-footer{
		padding-left:15px;
	}
}

</style>

<script>
import Icon from './Icon.vue'

export default {
  props: [],
  setup(props) {
    console.log(props)
  },
  components: {
      Icon
  },
  loginAdmin(){
    //this.props.loginUser({email: "sgrjr@deliverance.me", password: "1230happy"});
    //return <Navigate to={"/dashboard/admin/users"} />
    console.log('impletemnt admin login feature')
    },
}
</script>

