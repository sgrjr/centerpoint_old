const DEFAULT_STATE = {title:null, titles:[]}
let INITIAL_STATE = window.INITIAL_STATE? window.INITIAL_STATE:DEFAULT_STATE

if(INITIAL_STATE.title === undefined || INITIAL_STATE.titles === undefined){
        INITIAL_STATE = DEFAULT_STATE
}

export default {
        queried: 0,
        pending: false,
        errors: [],
        pagination: {
                page: 1,
                perPage: 10
        },
        lists:  INITIAL_STATE.titles,
        title: INITIAL_STATE.title,
        titlepending: false,
        titleGetUserData: INITIAL_STATE.title && INITIAL_STATE.title.user === undefined? false:true,
        query: (variables) => {
            return {
            query:`
        fragment TitleFragment on TitlePaginator {
          paginatorInfo {
            count
            currentPage
            firstItem
            hasMorePages
            lastItem
            lastPage
            perPage
            total
          }
          data {
            INDEX
            ISBN
            TITLE
            INVNATURE
            LISTPRICE
            PUBDATE
            coverArt
          }
        }
        query($cp: TitleFilter, $trade: TitleFilter, $advanced: TitleFilter, $page: Int, $cp_limit: Int, $trade_limit: Int, $advanced_limit: Int) {
          cp: titles(filter: $cp, page: $page, first:$cp_limit) {
            ...TitleFragment
          }
          trade: titles(filter: $trade, page: $page, first:$trade_limit) {
            ...TitleFragment
          }
          advanced: titles(filter: $advanced, page: $page, first:$advanced_limit) {
            ...TitleFragment
          }
        }
            `, 
            variables: variables
          }
        },

        queryVars: {
          page: 1,
          cp: {date:"20170000"},
          cp_limit: 15,
          trade: {date:"20170000"},
          trade_limit:15,
          advanced: {date:"20170000"},
          advanced_limit:30
        },

     titleQuery: (variables) => {
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
      sameCAT: titles(page: $page, first: $perPage, key: "CAT") {
        INDEX
        ISBN
        TITLE
        PICLOC
        defaultImage
        LISTPRICE
      }
      sameAUTHOR: titles(page: $page, first: $perPage, key: "AUTHORKEY") {
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
  
  },

minTitleQuery: (variables) => {
    return {
    
    query:`query ($page: Int, $perPage:Int, $isbn:String) {
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
          sameCAT: titles(page: $page, first: $perPage, key:"CAT") {
            INDEX
            ISBN
            TITLE
            PICLOC
            defaultImage
            LISTPRICE
          }
          sameAUTHOR: titles(page: $page, first: $perPage, key:"AUTHORKEY") {
            INDEX
            ISBN
            TITLE
            PICLOC
            AUTHORKEY
            defaultImage
            LISTPRICE
          }
          text {
            body {
              type
              subject
              body
            }
          }
        }
      }
    }  
    `, 
    variables: variables
  }
  
  },

  searchQuery: (variables = {}) => {
    return {
    
    query:`query($page: Int, $perPage: Int, $filters: TitleFilter) {
  search: titles(page: $page, first: $perPage, filter: $filters) {
    paginatorInfo {
      count
      currentPage
      firstItem
      hasMorePages
      lastItem
      lastPage
      perPage
      total
    }
    data {
      INDEX
      ISBN
      TITLE
      INVNATURE
      LISTPRICE
      coverArt
      CAT
      AUTHOR
      FORMAT
      SOPLAN
      PUBDATE
      STATUS
      PUBLISHER
    }
  }
}  
    `, 
    variables: variables
  }

  }


}