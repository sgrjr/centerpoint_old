import graphql from '../fetchGraphQL'
import cartCreateMutation from '../Cart/cartCreateMutation'
import cartDeleteMutation from '../Cart/cartDeleteMutation'
import cartTitleDeleteMutation from '../Cart/cartTitleDeleteMutation'
import cartTitleUpdateMutation from '../Cart/cartTitleUpdateMutation'
import cartSubmitMutation from '../Cart/cartSubmitMutation'

/* VIEWER TYPES AND CREATORS */ 
const cart = { 

  CART_SELECT: 
  {
      type: 'CART_SELECT',   
      creator: (cartId) => {
        return { type: 'CART_SELECT', cartId: cartId }
      }
  },

  SELECT_TITLE_QUANTITY: 
  {
      type: 'SELECT_TITLE_QUANTITY',   
      creator: (qty) => {
        return { type: 'SELECT_TITLE_QUANTITY', selectedQuantity: qty }
      }
  },

  CART_PENDING: 
  {
      type: 'CART_PENDING',   
      creator: () => {
        return { type: 'CART_PENDING' }
      }
  },

  CART_TITLE_ADDED_SUCCESS: 
  {
      type: 'CART_TITLE_ADDED_SUCCESS',   
      creator: (payload) => {
        return { type: 'CART_TITLE_ADDED_SUCCESS', payload: payload.createCartTitle }
      }
  },

  CART_SUCCESS: 
  {
      type: 'CART_SUCCESS',   
      creator: (payload) => {
        return { type: 'CART_SUCCESS', payload }
      }
  },

  CART_ERROR: 
  {
      type: 'CART_ERROR',   
      creator: (errors) => {
        return { type: 'CART_ERROR', errors }
      }
  },  
  
  CART_GET: 
  {
      type: 'CART_GET',   
      creator: (query) => {
        const actions = {
          pending: cart.CART_PENDING.creator,
          success: cart.CART_SUCCESS.creator,
          error: cart.CART_ERROR.creator
        }
        return graphql(query, actions)
      }
  },

  INVOICE_GET: 
  {
      type: 'INVOICE_GET',   
      creator: (query) => {
        const actions = {
          pending: cart.INVOICE_PENDING.creator,
          success: cart.INVOICE_SUCCESS.creator,
          error: cart.INVOICE_ERROR.creator
        }
        return graphql(query, actions)
      }
  },

  INVOICE_PENDING: 
  {
      type: 'INVOICE_PENDING',   
      creator: (variables) => {
        return { type: 'INVOICE_PENDING', variables }
      }
  },

  INVOICE_SUCCESS: 
  {
      type: 'INVOICE_SUCCESS',   
      creator: (payload) => {
        return { type: 'INVOICE_SUCCESS', payload: payload.viewer.cart }
      }
  },

  INVOICE_ERROR: 
  {
      type: 'INVOICE_ERROR',   
      creator: (errors) => {
        return { type: 'INVOICE_ERROR', errors }
      }
  }, 

  POST_TITLE_TO_CART: 
  {
    type: 'POST_TITLE_TO_CART',   
    creator: (query) => {
      const actions = {
        pending: cart.CART_PENDING.creator,
        success: cart.CART_TITLE_ADDED_SUCCESS.creator,
        error: cart.CART_ERROR.creator
      }
      return graphql(query, actions)
    } 
    
  },

  TOGGLE_CART: 
  {
    type: 'TOGGLE_CART',   
    creator: () => {
      return { type: 'TOGGLE_CART' }
    } 
    
  },

  CART_UPDATE_FORM: 
  {
    type: 'CART_UPDATE_FORM',   
    creator: (index, key, value) => {
      return { type: 'CART_UPDATE_FORM', index, key, value }
    }
  },

  CHECKOUT_UPDATE: 
  {
    type: 'CHECKOUT_UPDATE',   
    creator: (e) => {
      e.preventDefault()
      return { type: 'CHECKOUT_UPDATE', input: {name: e.target.name, value: e.target.value} }
    }
  },

  CART_UPDATE_TITLE: 
  {
    type: 'CART_UPDATE_TITLE',   
    creator: (attributes) => {
      
      const actions = {
        pending: cart.CART_TITLE_UPDATE_PENDING.creator,
        success: cart.CART_TITLE_UPDATE_SUCCESS.creator,
        error: cart.CART_ERROR.creator
      }

      const query = cartTitleUpdateMutation(attributes)
      return graphql(query, actions)

    } 
    
  },

  CART_TITLE_UPDATE_PENDING: 
  {
    type: 'CART_TITLE_UPDATE_PENDING',   
    creator: (variables) => {
      return { type: 'CART_TITLE_UPDATE_PENDING', variables }
    } 
    
  },

  CART_DELETE: 
  {
    type: 'CART_DELETE',   
    creator: (variables) => {
      const actions = {
        pending: cart.CART_PENDING.creator,
        success: cart.CART_DELETE_SUCCESS.creator,
        error: cart.CART_ERROR.creator
      }

      const query = cartDeleteMutation(variables);

      return graphql(query, actions)
    }
  },

  CART_CREATE: 
  {
    type: 'CART_CREATE',   
    creator: () => {
      const actions = {
        pending: cart.CART_CREATE_PENDING.creator,
        success: cart.CART_CREATE_SUCCESS.creator,
        error: cart.CART_ERROR.creator
      }

      const query = cartCreateMutation();

      return graphql(query, actions)
    } 
    
  },

  CART_DELETE_TITLE: 
  {
    type: 'CART_DELETE_TITLE',   
    creator: (variables) => {

      const actions = {
        pending: cart.CART_DELETE_TITLE_PENDING.creator,
        success: cart.CART_DELETE_TITLE_SUCCESS.creator,
        error: cart.CART_ERROR.creator
      }

      const query = cartTitleDeleteMutation(variables);

      return graphql(query, actions)
    } 
    
  },

  CART_CHECKOUT: 
  {
    type: 'CART_CHECKOUT',   
    creator: (props) => {
      let p = {...props}
      delete p.INDEX;
      delete p.items;
      delete p.invoice;
      p.ISCOMPLETE = true

      const query = cartSubmitMutation({input:p})
      
      const actions = {
        pending: cart.CART_SAVE_PENDING.creator,
        success: cart.CART_SAVE_SUCCESS.creator,
        error: cart.CART_ERROR.creator
      }

      return graphql(query, actions)
    } 
    
  },

  CART_SAVE: 
  {
    type: 'CART_SAVE',   
    creator: (query) => {
      const actions = {
        pending: cart.CART_SAVE_PENDING.creator,
        success: cart.CART_SAVE_SUCCESS.creator,
        error: cart.CART_SAVE_ERROR.creator
      }

      return graphql(query, actions)
    } 
  },

  CART_SAVE_SUCCESS: 
  {
      type: 'CART_SAVE_SUCCESS',   
      creator: (payload) => {
        return { type: 'CART_SAVE_SUCCESS', payload: payload.updatecartpreferences }
      }
  },

  CART_SAVE_ERROR: 
  {
      type: 'CART_SAVE_ERROR',   
      creator: (errors) => {
        return { type: 'CART_SAVE_ERROR', errors }
      }
  },
  CART_TITLE_UPDATE_SUCCESS: 
  {
      type: 'CART_TITLE_UPDATE_SUCCESS',   
      creator: (payload) => {
        return { type: 'CART_TITLE_UPDATE_SUCCESS', payload: payload.updateCartTitle }
      }
  },

  CART_SAVE_PENDING: 
  {
      type: 'CART_SAVE_PENDING',   
      creator: (variables) => {
        return { type: 'CART_SAVE_PENDING', variables }
      }
  },

  CART_DELETE_SUCCESS: 
  {
      type: 'CART_DELETE_SUCCESS',   
      creator: (data) => {
        return { type: 'CART_DELETE_SUCCESS', viewer:data.deleteCart }
      }
  },

  CART_DELETE_TITLE_PENDING: 
  {
      type: 'CART_DELETE_TITLE_PENDING',   
      creator: () => {
        return { type: 'CART_DELETE_TITLE_PENDING' }
      }
  },

  CART_DELETE_TITLE_SUCCESS: 
  {
      type: 'CART_DELETE_TITLE_SUCCESS',   
      creator: (payload) => {
        console.log(payload, 77)
        return { type: 'CART_DELETE_TITLE_SUCCESS', data: payload.deleteCartTitle  }
      }
  },

  CART_CREATE_SUCCESS: 
  {
      type: 'CART_CREATE_SUCCESS',   
      creator: (data) => {
        return { type: 'CART_CREATE_SUCCESS', data: data.createCart  }
      }
  },

  CART_CREATE_PENDING: 
  {
      type: 'CART_CREATE_PENDING',   
      creator: (variables) => {
        return { type: 'CART_CREATE_PENDING', variables  }
      }
  },

}

export default cart;