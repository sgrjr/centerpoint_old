import graphql from '../fetchGraphQL'
import authorization from '../authorization'
import q from '../reducers/queries'

/* AUTH TYPES AND CREATORS */ 
const auth = { 

  AUTH_PENDING: 
  {
      type: 'AUTH_PENDING',   
      creator: () => {
        return { type: 'AUTH_PENDING', message:{message:"Authentication pending...", severity:"info"} }
      }
  },

  AUTH_LOGOUT_PENDING: 
  {
      type: 'AUTH_LOGOUT_PENDING',   
      creator: () => {
        //authorization.destroy();
        return { type: 'AUTH_LOGOUT_PENDING', message:{message:"Logout pending...", severity:"info"} }
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
          authorization.store(data.token.plainTextToken);
          return { type: 'AUTH_SUCCESS', payload: data, message:{message:"You are Logged in.", severity:"success"}}
        }else{
          return { type: 'AUTH_ERROR', errors: data.errors}
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
        pending: auth.AUTH_LOGOUT_PENDING.creator,
        success: auth.AUTH_LOGOUT_SUCCESS.creator,
        error: auth.AUTH_LOGOUT_ERROR.creator
      }
    
      return graphql(query, actions)
  }
},
  AUTH_ERROR: 
  {
      type: 'AUTH_ERROR',
      creator: (errors) => {
        return { type: 'AUTH_ERROR', errors: errors }
      }
  },  
  
  AUTH_LOGOUT_ERROR: 
  {
      type: 'AUTH_LOGOUT_ERROR',
      creator: (errors) => {
        return { type: 'AUTH_LOGOUT_ERROR', errors: errors }
      }
  },  

  AUTH_GET: 
  {
      type: 'AUTH_GET',   
      creator: (creds) => {
        let query = null;
          
          const {email, password} = creds

          query ={
            variables:{ email: email, password: password, cartsLimit:100}, 
            query: q.fragments([ 'user','order','orderItem'],`mutation($email: String!, $password: String!, $cartsLimit: Int!){
          loginUser(input: {email: $email, password: $password}) {
            token{
              plainTextToken
            }

             errors {
              message
              debugMessage {
                id
                message
              }
              severity
              field
              extensions{
                category
                validation{
                  EMAIL
                  password
                }
              }
            }
            
            user{
            ...UserFragment
                vendor{
                  carts(first:$cartsLimit){
                    paginatorInfo{
                      count
                    }
                    data{
                      ...OrderFragment

                      items{
                        ...OrderItemFragment
                      }
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
    
        }`)};
     
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
 
          query ={
            variables: {
              loginInput: {
                id: id
              },
              cartsLimit:100
          }, 
          query: `mutation {
          adminLoginUser(input: $loginInput) {
            token
            id
            KEY
            EMAIL
            name
                vendor{
                  carts(first:$cartsLimit){
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
                              TITLE
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