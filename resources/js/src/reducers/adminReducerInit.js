

export default {
    pending:false,
    links:[
        {url:"#", text:"Main", icon:"HEADING"},
        {url:"/cms", text:"Admin Home", icon:"lockOpen"}
    ],
    error: false,
    data: {},
    progress: {
      start: 0,
      end:0
    },
      adminQuery: `query{viewer{EMAIL}}`,
      titlesQuery: {
        "page":1,
        "perPage":10
      },
      titleQuery: {
        "page":1,
        "perPage":10,
        "isbn": "9781611731996"
      },
}