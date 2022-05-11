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
          action:'APP_GET',
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
          action:'APP_UPDATE',
          pending: application.APP_PENDING.creator,
          success: application.APP_UPDATE_SUCCESS.creator,
          error: application.APP_ERROR.creator
        }
        return graphql(query, actions)
      }
  },

  TOGGLE_OLD_WEBSITE: 
  {
      type: 'TOGGLE_OLD_WEBSITE',   
      creator: (current) => {
        if(!current){
          localStorage.setItem('old_centerpoint_website', 'true')
        }else{
          localStorage.setItem('old_centerpoint_website','false')
        }
        return { type: 'TOGGLE_OLD_WEBSITE' , value: current}
      }
  }

}

export default application;