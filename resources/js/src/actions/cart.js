import graphql from '../fetchGraphQL'

import cartUpdateMutation from '../Cart/cartUpdateMutation'
import cartCreateMutation from '../Cart/cartCreateMutation'
import cartDeleteMutation from '../Cart/cartDeleteMutation'

import cartTitleDeleteMutation from '../Cart/cartTitleDeleteMutation'
import cartTitleUpdateMutation from '../Cart/cartTitleUpdateMutation'

/* VIEWER TYPES AND CREATORS */ 
const cart = { 

  CART_SELECT: 
  {
      type: 'CART_SELECT',   
      creator: (cartId) => {
        return { type: 'CART_SELECT', cartId: cartId, message:{message:"Cart changed.", severity:"success"} }
      }
  },

  SELECT_TITLE_QUANTITY: 
  {
      type: 'SELECT_TITLE_QUANTITY',   
      creator: (qty) => {
        return { type: 'SELECT_TITLE_QUANTITY', selectedQuantity: qty, message:{message:"Title quantity chagned.", severity:"success"} }
      }
  },

  CART_PENDING: 
  {
      type: 'CART_PENDING',   
      creator: (vars) => {
        return { type: 'CART_PENDING', vars: vars, message:{message:"Updating Cart Changes ... ", severity:"info"} }
      }
  },

  CART_TITLE_ADDED_PENDING: 
  {
      type: 'CART_TITLE_ADDED_PENDING',   
      creator: (vars) => {
        return { type: 'CART_TITLE_ADDED_PENDING', vars: vars, message:{message:"Adding "+vars.ISBN+" to Cart ... ", severity:"info"}      }
      }
  },


  CART_TITLE_ADDED_SUCCESS: 
  {
      type: 'CART_TITLE_ADDED_SUCCESS',   
      creator: (payload) => {
        return { type: 'CART_TITLE_ADDED_SUCCESS', payload: payload.updateOrCreateCartTitle, message:{message: "Title added to cart.", severity:"success"} }
      }
  },

  CART_SUCCESS: 
  {
      type: 'CART_SUCCESS',   
      creator: (payload) => {
        return { type: 'CART_SUCCESS', payload, message:{message:"Cart loaded", severity:"success", message:{message:"Cart updated.", severity:"success"}} }
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
        return { type: 'INVOICE_PENDING', variables, message: {message:"Invoice pending ... ", severity:"warning"} }
      }
  },

  INVOICE_SUCCESS: 
  {
      type: 'INVOICE_SUCCESS',   
      creator: (payload) => {
        let pl = {}

        if(payload.viewer.cart){
          pl = payload.viewer.cart
        }else{
          pl = payload.viewer.invoice
          pl.ISCOMPLETE = true
        }
        return { type: 'INVOICE_SUCCESS', payload: pl, message: {message:"Invoice loaded", severity:"success"} }
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
        pending: cart.CART_TITLE_ADDED_PENDING.creator,
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
      return { type: 'TOGGLE_CART', message:{message:"Cart Toggled on/off", severity:"success"} }
    } 
    
  },

  CART_UPDATE_FORM: 
  {
    type: 'CART_UPDATE_FORM',   
    creator: (index, key, value) => {
      return { type: 'CART_UPDATE_FORM', index, key, value, message:{message:"Send Update to Cart form.", severity:"info"} }
    }
  },

  CHECKOUT_UPDATE: 
  {
    type: 'CHECKOUT_UPDATE',   
    creator: (e) => {
      e.preventDefault()
      return { type: 'CHECKOUT_UPDATE', input: {name: e.target.name, value: e.target.value, message:{message:"Send update to checkout cart ... ", severity:"info"}} }
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

      const query = cartTitleUpdateMutation({input:attributes})
      return graphql(query, actions)

    } 
    
  },

  CART_TITLE_UPDATE_PENDING: 
  {
    type: 'CART_TITLE_UPDATE_PENDING',   
    creator: (variables) => {
      return { type: 'CART_TITLE_UPDATE_PENDING', variables, message:{message:"Title Update Pending: " + variables.REQUESTED +" ...", severity:"info"} }
    } 
    
  },

  CART_DELETE: 
  {
    type: 'CART_DELETE',   
    creator: (variables) => {
      const actions = {
        pending: cart.CART_DELETE_PENDING.creator,
        success: cart.CART_DELETE_SUCCESS.creator,
        error: cart.CART_ERROR.creator
      }

      const query = cartDeleteMutation(variables);

      return graphql(query, actions)
    }
  },

  CART_DELETE_PENDING: 
  {
      type: 'CART_DELETE_PENDING',   
      creator: (vars) => {
        return { type: 'CART_DELETE_PENDING', vars: vars }
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
      const input = {}
      const query = cartCreateMutation({input:input});

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
      p.id = parseInt(p.id)
      const query = cartUpdateMutation({input:p})
      
      const actions = {
        pending: cart.CART_UPDATE_PENDING.creator,
        success: cart.CART_UPDATE_SUCCESS.creator,
        error: cart.CART_UPDATE_ERROR.creator
      }

      return graphql(query, actions)
    } 
    
  },

  CART_UPDATE: 
  {
    type: 'CART_UPDATE',   
    creator: (query) => {
      const actions = {
        pending: cart.CART_UPDATE_PENDING.creator,
        success: cart.CART_UPDATE_SUCCESS.creator,
        error: cart.CART_UPDATE_ERROR.creator
      }
      if (query.variables.input.INDEX){query.variables.input.INDEX = parseInt(query.variables.input.INDEX);}
      if (query.variables.input.id){query.variables.input.id = parseInt(query.variables.input.id);}

      return graphql(query, actions)
    } 
  },

  CART_UPDATE_SUCCESS: 
  {
      type: 'CART_UPDATE_SUCCESS',   
      creator: (payload) => {
        return { type: 'CART_UPDATE_SUCCESS', payload: payload.updateOrCreateCart, message:{message:"Cart updated.", severity:"success"} }
      }
  },

  CART_UPDATE_ERROR: 
  {
      type: 'CART_UPDATE_ERROR',   
      creator: (errors) => {
        return { type: 'CART_UPDATE_ERROR', errors }
      }
  },
  CART_TITLE_UPDATE_SUCCESS: 
  {
      type: 'CART_TITLE_UPDATE_SUCCESS',   
      creator: (payload) => {
        console.log(payload)
        return { type: 'CART_TITLE_UPDATE_SUCCESS', payload: payload.updateOrCreateCartTitle, message:{message:"Cart title updated.", severity:"success"}  }
      }
  },

  CART_UPDATE_PENDING: 
  {
      type: 'CART_UPDATE_PENDING',   
      creator: (variables) => {
        return { type: 'CART_UPDATE_PENDING', variables, message:{message:"Cart changes pending.", severity:"info"}  }
      }
  },

  CART_DELETE_SUCCESS: 
  {
      type: 'CART_DELETE_SUCCESS',   
      creator: (data) => {
        return { type: 'CART_DELETE_SUCCESS', viewer:data.deleteCart, message: {message:"Cart Deleted", severity:"success"} }
      }
  },

  CART_DELETE_TITLE_PENDING: 
  {
      type: 'CART_DELETE_TITLE_PENDING',   
      creator: (input) => {
        return { type: 'CART_DELETE_TITLE_PENDING', input:input, message:{message:"Delete Title pending....", severity:"info"}  }
      }
  },

  CART_DELETE_TITLE_SUCCESS: 
  {
      type: 'CART_DELETE_TITLE_SUCCESS',   
      creator: (payload) => {
        return { type: 'CART_DELETE_TITLE_SUCCESS', data: payload.deleteCartTitle, message:{message:"Delete Title from Cart success.", severity:"success"}   }
      }
  },

  CART_CREATE_SUCCESS: 
  {
      type: 'CART_CREATE_SUCCESS',   
      creator: (data) => {
        return { type: 'CART_CREATE_SUCCESS', data: data.updateOrCreateCart, message:{message:"Cart created.", severity:"success"}   }
      }
  },

  CART_CREATE_PENDING: 
  {
      type: 'CART_CREATE_PENDING',   
      creator: (variables) => {
        return { type: 'CART_CREATE_PENDING', variables, message:{message:"Creating cart ...", severity:"info"}   }
      }
  },

}

export default cart;