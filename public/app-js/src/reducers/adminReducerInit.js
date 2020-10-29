import titlesQuery from '../ProductStore/titlesQuery'
import titleQuery from '../ProductStore/titlePageQuery'
import defaultQuery from '../components/defaultQuery'

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
      adminQuery: defaultQuery(),
      titlesQuery: titlesQuery({
        "page":1,
        "perPage":10
      }),
      titleQuery: titleQuery({
        "page":1,
        "perPage":10,
        "isbn": "9781611731996"
      }),
}