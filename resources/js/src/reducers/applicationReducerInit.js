import q from './queries'

export default {
    pending: false,
    error: false,
    client: "cp",
    domain: "centerpointlargeprint.com",
    appdescription:"The Smart Choice for Large Print! | 1-800-929-9108",
    sitename: "Center Point Large Print",
    search: "",
    searchFilters: ["title","author","isbn","listprice"],
    searchFilter: "title",
    browse:[],
    catalog:{
        image_link:"",
        pdf_link:""
      },
    links:{
        drawer:[{url:"/",text:"Home"},{url:"/login",text:"Login"},{url:"/",text:"CP Connection"},{url:"/",text:"Catalogues &amp; Flyers"}],
        main:[{url:"/",text:"Home"},{url:"/login",text:"Login"}], 
        shortCuts:[]
      },
    slider: {slides: []},
    marcLink: null,
    oldWebsite: localStorage.getItem('old_centerpoint_website') && localStorage.getItem('old_centerpoint_website') === "true"? true:false

    //...window.INITIAL_STATE && window.INITIAL_STATE.application? window.INITIAL_STATE.application:{}
}