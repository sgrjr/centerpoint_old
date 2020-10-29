export default (variables) => {
    return {
    
    query:`query ($page: Int, $perPage: Int, $isbn: String) {
  viewer {
    title(filters: {ISBN: $isbn}) {
      LISTPRICE
      INDEX
      AUTHOR
      AFIRST
      ALAST
      SUFFIX
      AUTHORKEY
      ISBN
      TITLE
      FORMAT
      SUBTITLE
      HIGHLIGHT
      PICLOC
      CAT
      AUTHORKEY
      INVNATURE
      PAGES
      PUBDATE
      STATUS
      defaultImage
      MARC
      text {
        body {
          type
          subject
          body
        }
      }
      user {
        price
        discount
        purchased
        onstandingorder
      }
      sameCAT: titles(page: $page, perPage: $perPage, key: "CAT") {
        INDEX
        ISBN
        TITLE
        PICLOC
        defaultImage
        LISTPRICE
      }
      sameAUTHOR: titles(page: $page, perPage: $perPage, key: "AUTHORKEY") {
        INDEX
        ISBN
        TITLE
        PICLOC
        AUTHORKEY
        defaultImage
        LISTPRICE
      }
    }
  }
}
    `, 
    variables: variables
  }
  
  };