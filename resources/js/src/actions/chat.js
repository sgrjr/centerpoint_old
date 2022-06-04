import fetchPost from '../fetchPost'

/* VIEWER TYPES AND CREATORS */ 
const chat = { 

  MESSAGES_GET: 
  {
      type: 'MESSAGES_GET',   
      creator: (query) => {
        const actions = {
          action:'MESSAGES_GET',
          pending: chat.MESSAGES_PENDING.creator,
          success: chat.MESSAGES_SUCCESS.creator,
          error: chat.MESSAGES_ERROR.creator
        }
        const url = "/chat/messages";
        const options = {
          method: "GET"
        }
        const data = {}
        return fetchPost(url, data, options, actions)
      }
  }, 

  MESSAGES_PENDING:
  {
      type: 'MESSAGES_PENDING',   
      creator: () => {
        return { type: 'MESSAGES_PENDING'}
      }
  },

  MESSAGES_SUCCESS:
  {
      type: 'MESSAGES_SUCCESS',   
      creator: (payload) => {
        return { type: 'MESSAGE_SEND', payload: payload }
      }
  },

  MESSAGES_ERROR:
  {
      type: 'MESSAGES_ERROR',   
      creator: (payload) => {
        return { type: 'MESSAGES_ERROR', payload: payload }
      }
  },

  MESSAGE_SEND:
  {
      type: 'MESSAGE_SEND',   
      creator: (message) => {
        const actions = {
          action:'MESSAGE_SEND',
          pending: chat.MESSAGES_PENDING.creator,
          success: chat.MESSAGES_SUCCESS.creator,
          error: chat.MESSAGES_ERROR.creator
        }
        const url = "/chat/messages";
        const options = {
          method: "POST"
        }
        const data = {message: message}
        return fetchPost(url, data, options, actions)
      }
  }, 

  MESSAGE_ADD_USERS:
  {
      type: 'MESSAGE_ADD_USERS',   
      creator: (users) => {
        return { type: 'MESSAGE_ADD_USERS', users: users }
      }
  },

  MESSAGE_JOIN_USER:
  {
      type: 'MESSAGE_JOIN_USER',   
      creator: (user) => {
        return { type: 'MESSAGE_JOIN_USER', user: user }
      }
  },

  MESSAGE_EXIT_USER:
  {
      type: 'MESSAGE_EXIT_USER',   
      creator: (user) => {
        return { type: 'MESSAGE_EXIT_USER', user: user }
      }
  },

  MESSAGE_EXIT_USER:
  {
      type: 'MESSAGE_EXIT_USER',   
      creator: (user) => {
        return { type: 'MESSAGE_EXIT_USER', user: user }
      }
  },


}

export default chat;