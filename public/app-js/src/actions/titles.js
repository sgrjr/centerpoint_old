import graphql from '../fetchGraphQL'

import act from './index'

/* TITLES TYPES AND CREATORS */ 
const titles = { 

  TITLES_INCREMENT_PERPAGE: 
  {
      type: 'TITLES_INCREMENT_PERPAGE',   
      creator: () => {
        return { type: 'TITLES_INCREMENT_PERPAGE'}
      }
  },

  TITLES_GET: 
  {
      type: 'TITLES_GET',   
      creator: (query) => {
        const actions = {
          pending: titles.TITLES_PENDING.creator,
          success: titles.TITLES_SUCCESS.creator,
          error: act.notification.NOTIFICATION_ADD_ERROR.creator
        }
        return graphql(query, actions)
      }
  },

  TITLES_PENDING: 
{
    type: 'TITLES_PENDING',   
    creator: (q) => {
      return { type: 'TITLES_PENDING', query:q}
    }
},

TITLES_SUCCESS: 
{
    type: 'TITLES_SUCCESS',   
    creator: (payload) => {
      return { type: 'TITLES_SUCCESS', payload }
    }
},

TITLES_ERROR: 
{
    type: 'TITLES_ERROR',   
    creator: (errors) => {
      return { type: 'TITLES_ERROR', errors }
    }
},

TITLE_GET: 
{
    type: 'TITLE_GET',   
    creator: (query) => {
      const actions = {
        pending: titles.TITLE_PENDING.creator,
        success: titles.TITLE_SUCCESS.creator,
        error: titles.TITLE_ERROR.creator
      }
      return graphql(query, actions)
    }
},

TITLE_PENDING: 
{
  type: 'TITLE_PENDING',   
  creator: () => {
    return { type: 'TITLE_PENDING'}
  }
},

TITLE_SUCCESS: 
{
  type: 'TITLE_SUCCESS',   
  creator: (payload) => {
    return { type: 'TITLE_SUCCESS', payload }
  }
},

TITLE_ERROR: 
{
  type: 'TITLE_ERROR',   
  creator: (errors) => {
    return { type: 'TITLE_ERROR', errors }
  }
},

}

export default titles;