import graphql from '../fetchGraphQL'
import post from '../fetchPost'

/* ADMIN TYPES AND CREATORS */ 
const admin = { 

  ADMIN_GET: 
  {
      type: 'ADMIN_GET',   
      creator: (query) => {
        const actions = {
          pending: admin.ADMIN_PENDING.creator,
          success: admin.ADMIN_SUCCESS.creator,
          error: admin.ADMIN_ERROR.creator
        }
        return graphql(query, actions)
      }
  },  

  ADMIN_PENDING: 
  {
      type: 'ADMIN_PENDING',   
      creator: (query) => {
        return { type: 'ADMIN_PENDING', query,  message:{message:"Changes pending...", severity:"warning"} }
      }
  },
  ADMIN_SUCCESS: 
  {
      type: 'ADMIN_SUCCESS',   
      creator: (payload) => {
        return { type: 'ADMIN_SUCCESS', payload,  message:{message:"ADMIN_SUCCESS. Done.", severity:"success"}}
      }
  },
 
  ADMIN_ERROR: 
  {
      type: 'ADMIN_ERROR',   
      creator: (errors) => {
        return { type: 'ADMIN_ERROR', errors }
      }
  },

  UPDATE_ADMIN_QUERY: 
  {
    type: 'UPDATE_ADMIN_QUERY',   
    creator: (event) => {
      return { type: 'UPDATE_ADMIN_QUERY', value: event.target.value }
    }
  },

  ADMIN_GET_FOXPRO: 
  {
      type: 'ADMIN_GET',   
      creator: (url, data, options) => {
        const actions = {
          pending: admin.ADMIN_PENDING.creator,
          success: admin.ADMIN_SUCCESS.creator,
          error: admin.ADMIN_ERROR.creator
        }
        return post(url, data, options, actions)
      }
  },  

}

export default admin;