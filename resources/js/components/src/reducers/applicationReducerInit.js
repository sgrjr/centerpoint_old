export default {

    query: (variables) => {
        return {
  
      query:`query ($catalogId: String){
              application {
                client
                domain
                appDescription
                siteName
                searchFilters

                browse {
                  title
                  items {
                    url
                    text
                    icon
                  }
                }

                catalog(id: $catalogId) {
                  image_link
                  pdf_link
                }

                links {
                  main {
                    url
                    text
                    icon
                  }
                  drawer {
                    url
                    text
                    icon
                  }
                }

                slider {
                  height
                  background_color
                  slides {
                    image
                    caption
                    link
                  }
                }
                
              }
              
              viewer {
                  KEY
                  name
                  EMAIL
                  photo
                  vendor {
                    cartsCount
                    processingCount
                  }

              application {
                client
                domain
                appDescription
                siteName
                searchFilters

                browse {
                  title
                  items {
                    url
                    text
                    icon
                  }
                }

                catalog(id: $catalogId) {
                  image_link
                  pdf_link
                }

                links {
                  main {
                    url
                    text
                    icon
                  }
                  drawer {
                    url
                    text
                    icon
                  }
                }

                slider {
                  height
                  background_color
                  slides {
                    image
                    caption
                    link
                  }
                }
                
              }

                }
            }
      `,
      variables: variables
    }

},
    variables: {catalogId: "current_catalog"},
    pending: false,
    error: false,
    client: "cp",
    domain: "centerpointlargeprint.com",
    appdescription:"The Smart Choice for Large Print! | 1-800-929-9108",
    sitename: "Center Point Large Print",
    search: "",
    searchfilters: ["TITLE","AUTHOR","ISBN","LISTPRICE"],
    searchfilter: "TITLE",
    browse:[],
    catalog:{
        image_link:"",
        pdf_link:""
      },
    links:{
        drawer:[{url:"/",text:"Home"},{url:"/login",text:"Login"},{url:"/",text:"CP Connection"},{url:"/",text:"Catalogues &amp; Flyers"}],
        main:[{url:"/",text:"Home"},{url:"/login",text:"Login"}]},
    slider: {slides: []},

    //...window.INITIAL_STATE && window.INITIAL_STATE.application? window.INITIAL_STATE.application:{}
}