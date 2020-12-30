import graphql from '../fetchGraphQL'

/* VIEWER TYPES AND CREATORS */ 
const application = { 

  APP_PENDING: 
  {
      type: 'APP_PENDING',   
      creator: () => {
        return { type: 'APP_PENDING' }
      }
  },
  APP_SUCCESS: 
  {
      type: 'APP_SUCCESS',   
      creator: (payload) => {
        return { type: 'APP_SUCCESS', payload }
      }
  },
  APP_UPDATE_SUCCESS: 
  {
      type: 'APP_UPDATE_SUCCESS',   
      creator: (payload) => {
        return { type: 'APP_UPDATE_SUCCESS', payload }
      }
  },
  APP_ERROR: 
  {
      type: 'APP_ERROR',   
      creator: (error) => {
        return { type: 'APP_ERROR', error }
      }
  },  
  
  APP_GET: 
  {
      type: 'APP_GET',   
      creator: (query) => {
        const actions = {
          pending: application.APP_PENDING.creator,
          success: application.APP_SUCCESS.creator,
          error: application.APP_ERROR.creator
        }
        return graphql(query, actions)
      }
  },  
  
  APP_UPDATE: 
  {
      type: 'APP_UPDATE',   
      creator: (query) => {
        const actions = {
          pending: application.APP_PENDING.creator,
          success: application.APP_UPDATE_SUCCESS.creator,
          error: application.APP_ERROR.creator
        }
        return graphql(query, actions)
      }
  }

}

export default application;