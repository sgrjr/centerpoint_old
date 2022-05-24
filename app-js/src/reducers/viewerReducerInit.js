export default {
    pending: false,
    error: false,
    user: {
        token: "testtoken",
        authenticated: false,
        pending: false,
        error: false,
        photo: null,
        vendor:{
            processingcount: 0,
            cartscount:0,
            carts:[],
            processing:[]
        }
    },
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
    slider: {slides: [
        {
            name: "Random Name #1",
            description: "Probably the most random thing you have ever seen!"
        },
        {
            name: "Random Name #2",
            description: "Hello World!"
        }
    ]},

    ...window.INITIAL_STATE? window.INITIAL_STATE.viewer:{}
}