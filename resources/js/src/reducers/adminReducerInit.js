

export default {
    pending:false,
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