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
        if(payload.loginuser.user.authenticated){
          authorization.store(payload.loginuser.user.token);
          return { type: 'AUTH_SUCCESS', payload: payload.loginuser }
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
          return { type: 'AUTH_LOGOUT_SUCCESS', payload: payload.logoutuser }
        }
  },

  AUTH_LOGOUT: 
  {
    type: 'AUTH_LOGOUT',   
    creator: () => {

      authorization.destroy();
      
      const query ={query: `mutation {
        logoutuser {
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
          user {
            id
            token
            authenticated
            vendor{
              cartscount
              processingcount
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
          loginuser(email: "${email}", password: "${password}") {
            links{
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
              user {
                id
                token
                authenticated
                vendor{
                  cartscount
                  processingcount
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