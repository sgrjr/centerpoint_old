import graphql from '../fetchGraphQL'
import authorization from '../authorization'

/* AUTH TYPES AND CREATORS */ 
const auth = { 

  AUTH_PENDING: 
  {
      type: 'AUTH_PENDING',   
      creator: () => {
        return { type: 'AUTH_PENDING' }
      }
  },
  AUTH_SUCCESS: 
  {
      type: 'AUTH_SUCCESS',   
      creator: (payload) => {
        if(payload.loginUser.token){
          authorization.store(payload.loginUser.token);
          return { type: 'AUTH_SUCCESS', payload: payload.loginUser }
        }else{
          const error = {
            message: "Login Failed!",
            extensions: {
              "category": "graphql"
            },
            locations: [
              {
                "line": 3,
                "column": 5
              }
            
          ]};

          return { type: 'AUTH_ERROR', errors: [error] }
        }
        
      }
  },
  AUTH_LOGOUT_SUCCESS: 
  {
      type: 'AUTH_LOGOUT_SUCCESS',   
      creator: (payload) => {
          return { type: 'AUTH_LOGOUT_SUCCESS', payload: payload.logoutUser }
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
          }
        }
      }`};
    
      const actions = {
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
        
        let error = {
          message: "Login Failed!",
          extensions: {
            "category": "graphql"
          },
          locations: [
            {
              "line": 3,
              "column": 5
            }
          
        ]};
        
        return { type: 'AUTH_ERROR', errors: [error] }
      }
  },  
  
  AUTH_GET: 
  {
      type: 'AUTH_GET',   
      creator: (creds) => {
        const {email, password} = creds
        const query ={query: `mutation {
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
                      REMOTEADDR
                      PO_NUMBER
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
          pending: auth.AUTH_PENDING.creator,
          success: auth.AUTH_SUCCESS.creator,
          error: auth.AUTH_ERROR.creator
        }
      
        return graphql(query, actions)
      }
  }

}

export default auth;