import graphql from '../fetchGraphQL'
import authorization from '../authorization'

/* AUTH TYPES AND CREATORS */ 
const auth = { 

  AUTH_PENDING: 
  {
      type: 'AUTH_PENDING',   
      creator: () => {
        return { type: 'AUTH_PENDING', message:{message:"Authentication pending...", severity:"info"} }
      }
  },
  AUTH_SUCCESS: 
  {
      type: 'AUTH_SUCCESS',   
      creator: (payload) => {

        let data = {}

        if(payload.loginUser){
          data = payload.loginUser
        }else{
          data = payload.adminLoginUser
        }
        if(data.token){
          authorization.store(data.token);
          return { type: 'AUTH_SUCCESS', payload: data, message:{message:"You are Logged in.", severity:"success"}}
        }else{

          const error = {
            message: "Login Failed!",
            severity:"warning",
            extensions: {
              "category": "graphql"
            },
            locations: [{"line": 1,"column": 1}]};

          return { type: 'AUTH_ERROR', errors: [error] }
        }
        
      }
  },
  AUTH_LOGOUT_SUCCESS: 
  {
      type: 'AUTH_LOGOUT_SUCCESS',   
      creator: (payload) => {
          return { type: 'AUTH_LOGOUT_SUCCESS', payload: payload.logoutUser, message: {message:"You are Logged out.", severity:"success"} }
        }
  },

  AUTH_LOGOUT: 
  {
    type: 'AUTH_LOGOUT',   
    creator: () => {

      authorization.destroy();
      
      const query ={query: `mutation {
        logoutUser {

          links {
            drawer {
              url
              text
              icon
            }
            main {
              url
              text
              icon
            }
            shortCuts {
              url
              text
              icon
            }
          }
        }
      }`};
    
      const actions = {
         action:'AUTH_LOGOUT',
        pending: auth.AUTH_PENDING.creator,
        success: auth.AUTH_LOGOUT_SUCCESS.creator,
        error: auth.AUTH_ERROR.creator
      }
    
      return graphql(query, actions)
  }
},
  AUTH_ERROR: 
  {
      type: 'AUTH_ERROR',   
      

      creator: (errors) => {
        /*errors.push({
          message: "Login Failed!",
          severity:"error",
          extensions: {
            "category": "graphql"
          },
          locations: [
            {
              "line": 3,
              "column": 5
            }
          
        ]});*/


        return { type: 'AUTH_ERROR', errors: errors }
      }
  },  
  
  AUTH_GET: 
  {
      type: 'AUTH_GET',   
      creator: (creds) => {
        let query = null;
          
          const {email, password} = creds

          query ={query: `mutation {
          loginUser(input: {email: "${email}", password: "${password}"}) {
            token
            id
            KEY
            EMAIL
            name
                vendor{
                  carts(first:1000){
                    paginatorInfo{
                      count
                    }
                    data{
                      id
                      INDEX
                      KEY
                      DATE
                      PO_NUMBER
                      TRANSNO
                      REMOTEADDR
                      ISCOMPLETE

                      items{
                              id
                              INDEX
                              PROD_NO
                              title
                              REQUESTED
                              SALEPRICE
                              coverArt
                              AUTHOR
                              AUTHORKEY
                              url
                              INVNATURE
                            }
                    }
                  }
                }
              application{
                 links {
                  drawer {
                    url
                    text
                    icon
                  }
                  main {
                    url
                    text
                    icon
                  }
                  shortCuts {
                    url
                    text
                    icon
                  }
                  
                }
              }
              }

            
        }`};
     
        const actions = {
          action:'AUTH_GET',
          pending: auth.AUTH_PENDING.creator,
          success: auth.AUTH_SUCCESS.creator,
          error: auth.AUTH_ERROR.creator
        }
      
        return graphql(query, actions)
      }
  }, 

  ADMIN_GET_USER: 
  {
      type: 'ADMIN_GET_USER',   
      creator: (creds) => {
        let query = null;
          
          const {id} = creds
 
          query ={query: `mutation {
          adminLoginUser(input: {id: "${id}"}) {
            token
            id
            KEY
            EMAIL
            name
                vendor{
                  carts(first:1000){
                    paginatorInfo{
                      count
                    }
                    data{
                      id
                      INDEX
                      KEY
                      DATE
                      PO_NUMBER
                      TRANSNO
                      REMOTEADDR
                      ISCOMPLETE

                      items{
                              id
                              INDEX
                              PROD_NO
                              title
                              REQUESTED
                              SALEPRICE
                              coverArt
                              AUTHOR
                              AUTHORKEY
                              url
                            }
                    }
                  }
                }
              application{
                 links {
                  drawer {
                    url
                    text
                    icon
                  }
                  main {
                    url
                    text
                    icon
                  }
                  
                }
              }
              }

            
        }`};
     
        const actions = {
          action:'ADMIN_GET_USER',
          pending: auth.AUTH_PENDING.creator,
          success: auth.AUTH_SUCCESS.creator,
          error: auth.AUTH_ERROR.creator
        }
      
        return graphql(query, actions)
      }
  }

}

export default auth;