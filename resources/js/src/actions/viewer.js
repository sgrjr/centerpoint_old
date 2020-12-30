import graphql from '../fetchGraphQL'

/* VIEWER TYPES AND CREATORS */ 
const viewer = { 

  VIEWER_PENDING: 
  {
      type: 'VIEWER_PENDING',   
      creator: () => {
        return { type: 'VIEWER_PENDING' }
      }
  },
  VIEWER_SUCCESS: 
  {
      type: 'VIEWER_SUCCESS',   
      creator: (payload) => {
        return { type: 'VIEWER_SUCCESS', payload }
      }
  },
  VIEWER_UPDATE_SUCCESS: 
  {
      type: 'VIEWER_UPDATE_SUCCESS',   
      creator: (payload) => {
        return { type: 'VIEWER_UPDATE_SUCCESS', payload }
      }
  },
  VIEWER_ERROR: 
  {
      type: 'VIEWER_ERROR',   
      creator: (error) => {
        return { type: 'VIEWER_ERROR', error }
      }
  },  
  
  VIEWER_GET: 
  {
      type: 'VIEWER_GET',   
      creator: (query) => {
        const actions = {
          pending: viewer.VIEWER_PENDING.creator,
          success: viewer.VIEWER_SUCCESS.creator,
          error: viewer.VIEWER_ERROR.creator
        }
        return graphql(query, actions)
      }
  },  
  
  VIEWER_UPDATE: 
  {
      type: 'VIEWER_UPDATE',   
      creator: (query) => {
        const actions = {
          pending: viewer.VIEWER_PENDING.creator,
          success: viewer.VIEWER_UPDATE_SUCCESS.creator,
          error: viewer.VIEWER_ERROR.creator
        }
        return graphql(query, actions)
      }
  }

}

export default viewer;