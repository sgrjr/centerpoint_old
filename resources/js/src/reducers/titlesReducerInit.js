const DEFAULT_STATE = {title:null, titles:[]}
let INITIAL_STATE = window.INITIAL_STATE? window.INITIAL_STATE:DEFAULT_STATE

if(INITIAL_STATE.title === undefined || INITIAL_STATE.titles === undefined){
        INITIAL_STATE = DEFAULT_STATE
}

function pad(num, len) {
    var s = "000000000" + num;
    return s.substr(s.length-len);
}

const dn = Date.now();
const now = new Date(dn);

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
        fragment TitleFragment on Title {
            INDEX
            ISBN
            TITLE
            INVNATURE
            LISTPRICE
            PUBDATE
            coverArt
            AUTHORKEY
            AUTHOR
            STATUS
        }
        query {
          cpTitles {
            ...TitleFragment
          }
          tradeTitles{
            ...TitleFragment
          }
          advancedTitles {
            ...TitleFragment
          }
        }
            `, 
            variables: variables
          }
        },

/*
  date: String @where(operator: ">=", key:"PUBDATE", clause:"where")
  dateBefore: String @where(operator: "<=", key:"PUBDATE", clause:"where")
  invnature: String @like(key:"INVNATURE")
  onhand: Boolean @eq(key:"ONHAND")
  category: String @like( key:"CAT")
  status: String @like( key:"STATUS")
  reverseStatus: String @noteq( key: "STATUS")
  pubStatus: String @like( key:"PUBSTATUS")
  publisher: String @like( key:"PUBLISHER")

  console.log(pad(now.getFullYear(),4), pad(now.getDate(),2), pad(now.getMonth(),2))
  */

        queryVars: {
          page: 1,
          cp: {
            dateBefore:pad(now.getFullYear(),4) +  pad(now.getMonth()) + pad(now.getDate(),2),
            invnature: "CENTE"
          },
          cp_limit: 15,
          trade: {
            dateBefore:pad(now.getFullYear(),4) +  pad(now.getMonth()) + pad(now.getDate(),2),
            invnature: "TRADE"
          },
          trade_limit:15,
          advanced: {date:pad(now.getFullYear(),4) +  pad(now.getMonth()+1,2) + "00"},
          advanced_limit:30
        },

     titleQuery: (variables) => {
    return {
    
    query:`query ($page: Int, $perPage: Int, $isbn: String) {
 title(filter: { isbn: $isbn }) {
    id
    LISTPRICE
    INDEX
    AUTHOR
    AUTHORKEY
    ISBN
    TITLE
    FORMAT
    SUBTITLE
    HIGHLIGHT
    CAT
    AUTHORKEY
    INVNATURE
    PAGES
    PUBDATE
    STATUS
    coverArt
    MARC
    marcLink{
      view
      download
    }
    byCategory(page: $page, first: $perPage) {
      paginatorInfo {
        perPage
        lastPage
        total
        count
        currentPage
        firstItem
        lastItem
        hasMorePages
      }

      data {
        INDEX
        ISBN
        TITLE
        coverArt
        LISTPRICE
        AUTHORKEY
        AUTHOR
        INVNATURE
      }
    }
    byAuthor(page: $page, first: $perPage) {
      paginatorInfo {
        perPage
        lastPage
        total
        count
        currentPage
        firstItem
        lastItem
        hasMorePages
      }

      data {
        INDEX
        ISBN
        TITLE
        AUTHORKEY
        AUTHOR
        coverArt
        LISTPRICE
        STATUS
        INVNATURE
      }
    }
    text {
        body {
          type
          subject
          body
        }
    }
      user: userData {
        isbn
        price
        discount
        purchased
        onstandingorder
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
        title(filter: { isbn: $isbn }) {
    id
    LISTPRICE
    INDEX
    AUTHOR
    AUTHORKEY
    ISBN
    TITLE
    FORMAT
    SUBTITLE
    HIGHLIGHT
    CAT
    INVNATURE
    PAGES
    PUBDATE
    STATUS
    coverArt
    MARC
    marcLink{
      view
      download
    }
    byCategory(page: $page, first: $perPage) {
      paginatorInfo {
        perPage
        lastPage
        total
        count
        currentPage
        firstItem
        lastItem
        hasMorePages
      }

      data {
        INDEX
        ISBN
        TITLE
        coverArt
        LISTPRICE
        AUTHORKEY
        AUTHOR
        INVNATURE
      }
    }
    byAuthor(page: $page, first: $perPage) {
      paginatorInfo {
        perPage
        lastPage
        total
        count
        currentPage
        firstItem
        lastItem
        hasMorePages
      }

      data {
        INDEX
        ISBN
        TITLE
        AUTHORKEY
        AUTHOR
        coverArt
        LISTPRICE
        STATUS
        INVNATURE
      }
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
    `, 
    variables: variables
  }
  
  },

  searchQuery: (variables = {}) => {

    if(variables.filters.price !== undefined){
      variables.filters.price = parseFloat(parseFloat(variables.filters.price).toFixed(2))
    }

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
      AUTHORKEY
      FORMAT
      SOPLAN
      PUBDATE
      STATUS
      PUBLISHER
    }
  }

      searchSuggestions {
        data {
          id
          TITLE
          AUTHOR
          coverArt
          INVNATURE
          url
          featured
        }
        paginatorInfo{
          total
          count
        }
      }
}  
    `, 
    variables: variables
  }

  }


}