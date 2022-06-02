<template>
    <div class="main-navigation">
        <header>
            <p v-for="link of application.links.main" ><a :href="link.url"><Icon :name="link.icon"/><span>{{ link.text }}</span></a></p>
            <Cart />
        </header>
        <div class="search-form">
            <form>
                <select label-id="form-select" id="form-select" class="form-select">
                    <option value="title">Title</option><option value="isbns">ISBN</option>
                    <option value="author">Author</option><option value="price">Price</option>
                    <option value="genre">Genre</option><option value="series">Series</option>
                </select>
                <input id="search-input" placeholder="Search by title..." aria-label="search" value="">
                <button type="submit" class="icon-button" aria-label="search"><Icon name="search"/></button>
            </form>
        </div>
        
        <ul class="quick-links">
            <li><span><Icon name="more-vertical"/>Browse</span></li>
            <li><a href="/promotions">Catalogs and Flyers</a></li>
            <li><a href="/search/top-25-titles/list">Top 25 for June</a></li>
            <li><a href="/search/upcoming-titles/list">Upcoming Titles</a></li>
            <li><a href="/search/clearance-titles/list">Clearance Titles</a></li>
        </ul>
    </div>
</template>

<style lang="scss">
.main-navigation {
    background:url(/img/original/banner.png);
    height:309px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    margin-bottom:50px;
    align-items:flex-end;

    header {
        p:hover {
            background:rgba(127,127,127,.1);
        }

        p{
            font-size:1.2rem;
            margin-right:15px;
        }
    }

    svg {
        vertical-align: middle;
        height:1.2rem;
        fill: $white;
    }

    svg:hover{
        background:black;
    }

    button {
        background:transparent;
        border:none;
    }

      a {
        color: white;
        text-decoration: none;
        box-sizing: border-box;
      }

      a:hover { 
        color: $gray;
      }

    ul.quick-links {
        list-style: none;
        background-color:white;
        margin:0;
        display:flex;
        justify-content:center;
        padding-top:$standard_margin;
        font-size:115%;
        width:100%;

        li {
            display:inline;
            background: $gray;
            margin-right:$standard_margin;
            padding-right:$standard_margin;
            padding-left:$standard_margin;
            border: solid 2px $gray;
            height: 100%;
            margin-top: 0;
            margin-bottom:0;
            color:white;

            a {
                color:white;
                text-decoration:none;

                svg {
                float:left;
                vertical-align: middle;
                height:32px;
                fill: $white;
                }
            }


        }

        li:hover {
            background: white;
            color: $gray;

            a {
                color:$gray;
                text-decoration:none;
            }
        }
    }
}

.main-navigation header {
    background:none;
    display: flex;
    align-items: center;
    height:50px;
}

.search-form {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    box-sizing: border-box;
    align-items: flex-end;
    box-shadow: none;
    margin-bottom:$standard_margin;
    flex-direction:row-reverse;
    margin-top:200px;

    form {
        padding: 5px;
        border:none;
        line-height:45px;
        height:45px;
        background:rgba(255,255,255,.8);
        display:flex;
        justify-content:space-between;
        flex-basis:40%;
        gap:$standard_margin;
        margin-right:10%;

         button {
            border-radius:50%;
            width:35px;
            height:35px;
            background:transparent;
            border:none;
        }

        input {
            border-bottom: 1px solid $gray;
            height:100%;
            border:none;
            font-size:1.5rem;
            flex:1;
            background:transparent;
        }

        select {
            height:100%;
            border:none;
            font-size:1.25rem;
            flex: .3;
            background:white;
        }

    }
   
}


.main-navigation.minimal-navigation {
    border-bottom: solid 10px $blue;
    background:white;
    height:60px;
    overflow:hidden;
    position:fixed;
    width:100%;
    background-image:url(/img/logo.png);
    background-repeat:no-repeat;
    background-size:25px;
    background-position:left;
    background-position-x:$standard_margin;

    a {
        color: $blue;

    }

    }
@media only screen and (max-width: 760px) {
  .main-navigation{
      header{
          p{
              span{
                  display:none;
              }
          }
      }
  }
}

@media only screen and (max-width: 1199px) {
  .search-form form {
    flex-basis:100%;
    margin-right:0;
  }
}
</style>

<script>
import Icon from './Icon.vue'
import Cart from './Cart.vue'

export default {
  props: ['user', 'application'],
  setup(props) {
    console.log(props)
  },
  components: {
      Icon,
      Cart
  },
  data() {
    return {
      isActive: false,
    };
  },
}
</script>

