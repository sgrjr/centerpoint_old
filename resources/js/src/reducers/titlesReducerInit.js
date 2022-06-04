import q from './queries'

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
            query:q.fragments(['title','paginator'],`query ($first:Int!){
              cp: cpTitles (first:$first){
                paginatorInfo {
                  ...PaginatorInfoFragment
                }
                data{
                ...TitleFragment
                }
              }
              trade: tradeTitles(first:$first){
                paginatorInfo {
                  ...PaginatorInfoFragment
                }
                data{
                ...TitleFragment
                }
              }
              advanced: advancedTitles(first:$first) {
                paginatorInfo {
                  ...PaginatorInfoFragment
                }
                data{
                ...TitleFragment
                }
              }
            }
            `), 
            variables: variables
          }
        },

  titleQuery: (variables) => {
    return {
    
    query: q.fragments(['paginator','title','userData'],`query ($page: Int, $first: Int!, $isbn: String) {
 title(filter: { isbn: $isbn }) {
    paginatorInfo {
      ...PaginatorInfoFragment
    }
    data{
      ...TitleFragment
      marcLink{
        view
        download
      }
      byCategory(page: $page, first: $first) {
        paginatorInfo {
          ...PaginatorInfoFragment
        }
        data{
          ...TitleFragment
        }
      }
    
    byAuthor(page: $page, first: $first) {
      paginatorInfo {
        ...PaginatorInfoFragment
      }

      data {
        ...TitleFragment
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
        ...UserDataFragment
      }
  }
    }  
    `), 
    variables: variables
  }
  
  },

minTitleQuery: (variables) => {
    return {
    
    query: q.fragments(["title", "paginator"],`query ($page: Int, $first:Int!, $isbn:String) {
        title(filter: { isbn: $isbn }) {
          ...TitleFragment
        byCategory(page: $page, first: $first) {
          paginatorInfo {
            ...PaginatorInfoFragment
          }

          data {
            ...TitleFragment
          }
        }
        byAuthor(page: $page, first: $first) {
          paginatorInfo {
            ...PaginatorInfoFragment
          }

          data {
            ...TitleFragment
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
    `), 
    variables: variables
  }
  
  },

  searchQuery: (variables = {}) => {

    if(variables.filters.price !== undefined){
      variables.filters.price = parseFloat(parseFloat(variables.filters.price).toFixed(2))
    }

    return {
    
    query:q.fragments(['paginator','title'],`query($page: Int, $first: Int!, $filters: TitleFilter) {

  search: titles(page: $page, first: $first, filter: $filters) {
    paginatorInfo {
      ...PaginatorInfoFragment
    }
    data {
      ...TitleFragment
    }
  }

  searchSuggestions: lists(name:"search_suggestions", first:12){
    data{
      ...TitleFragment
    }
  }

}  
    `), 
    variables: variables
  }

  },

    listQuery: (variables = {}) => {

    return {
    
    query:q.fragments(['paginator'],`query($name: String, $first: Int!, $page: Int) {

      list: lists(name:$name, first:$first, page:$page){

        paginatorInfo {
          ...PaginatorInfoFragment
        }

        data{
          INDEX
          ISBN
          TITLE
          INVNATURE
          LISTPRICE
          FLATPRICE
          isClearance
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

    }  
    `), 
    variables: variables
  }

  }


}