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
        fragment TitleFragment on TitlePaginator {
             paginatorInfo {
              perPage
              total
              count
              currentPage
              firstItem
              lastItem
              hasMorePages
            }
            data{
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
        }
        query ($first:Int!){
          cp: cpTitles (first:$first){
            ...TitleFragment
          }
          trade: tradeTitles(first:$first){
            ...TitleFragment
          }
          advanced: advancedTitles(first:$first) {
            ...TitleFragment
          }
        }
            `, 
            variables: variables
          }
        },

  titleQuery: (variables) => {
    return {
    
    query:`query ($page: Int, $first: Int!, $isbn: String) {
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
    byCategory(page: $page, first: $first) {
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
    byAuthor(page: $page, first: $first) {
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
    
    query:`query ($page: Int, $first:Int!, $isbn:String) {
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
    byCategory(page: $page, first: $first) {
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
    byAuthor(page: $page, first: $first) {
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
    
    query:`query($page: Int, $first: Int!, $filters: TitleFilter) {

  search: titles(page: $page, first: $first, filter: $filters) {
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

  searchSuggestions: lists(name:"search_suggestions", first:12){
    data{
      TITLE
      PUBDATE
    }
  }

}  
    `, 
    variables: variables
  }

  },

    listQuery: (variables = {}) => {

    return {
    
    query:`query($name: String, $first: Int!, $page: Int) {

      list: lists(name:$name, first:$first, page:$page){

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

        data{
          TITLE
          PUBDATE
        }
      }

    }  
    `, 
    variables: variables
  }

  }


}