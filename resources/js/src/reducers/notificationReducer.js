import actions from '../actions'
  
  const initState = {
    open: true,
    item: {message:"Welcome to Centerpoint Large Print!", severity:"info"},
    items: [
      {message:"Welcome to Centerpoint Large Print!", severity:"info"}
    ]
}

//The reducer is a pure function that takes the previous state and an action, and 
// returns the next state.

export default (state = initState,action)=>{

    switch (action.type) {
        case actions.notification.NOTIFICATION_DISMISS.type:

          let newState = {...state}

          if(newState.items.length > 1 ){
            newState.items.pop()
            newState.open = true
            newState.item = newState.items[newState.items.length-1]
          }else{
            newState.items = []
            newState.item = {}
            newState.open = false
          }

          return newState;

        case actions.cart.CART_ERROR.type:
        case actions.cart.CART_UPDATE_ERROR.type:
        case actions.form.DOWNLOAD_MARCS_ERROR.type:
        case actions.form.UPLOAD_ERROR.type:
        case actions.cart.INVOICE_ERROR.type:
        case actions.notification.NOTIFICATION_ADD_ERROR.type:
        case actions.auth.AUTH_ERROR.type:
        case actions.admin.ADMIN_ERROR.type:

          newState = {
              ...state,
              items: [...action.errors,...state.items],
              open: true
          }
          newState.item = newState.items[newState.items.length-1]
          if(!newState.item.severity){
            newState.item.severity = "error"
          }
          return newState;

        case actions.cart.CART_SUCCESS.type:
        case actions.form.UPLOAD_SUCCESS.type:
        case actions.cart.CART_DELETE_SUCCESS.type:
        case actions.cart.CART_TITLE_ADDED_SUCCESS.type:
        case actions.cart.INVOICE_SUCCESS.type:
        case actions.cart.CART_TITLE_UPDATE_PENDING.type:
        case actions.cart.CART_TITLE_UPDATE_SUCCESS.type:
        case actions.cart.CART_UPDATE_PENDING.type:
        case actions.cart.CART_UPDATE_SUCCESS.type:
        case actions.cart.CART_CREATE_PENDING.type:
        case actions.cart.CART_CREATE_SUCCESS.type:
        case actions.cart.CART_TITLE_ADDED_PENDING.type:
        case actions.form.DOWNLOAD_MARCS_PENDING.type:
        case actions.form.DOWNLOAD_MARCS_SUCCESS.type:
        //case actions.form.CLEAR_MARC.type:
        //case actions.form.FORM_UPDATE_SUCCESS.type:
        case actions.auth.AUTH_LOGOUT_SUCCESS.type:
        case actions.auth.AUTH_SUCCESS.type:
        case actions.auth.AUTH_PENDING.type:
        case actions.admin.ADMIN_PENDING.type:
        case actions.admin.ADMIN_SUCCESS.type:
          newState = {...state}
          newState.items.unshift(action.message)
          if(newState.items.length > 1){newState.items.pop()}
          newState.open = true;
          newState.item = newState.items[newState.items.length-1]
          return newState;

        default:
          return state
      }
}