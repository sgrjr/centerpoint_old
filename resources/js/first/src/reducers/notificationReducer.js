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
        case actions.viewer.VIEWER_ERROR.type:

          let newErrors = []

          action.errors.map((er)=>{
            if(er.debugMessage !== undefined && er.debugMessage.message != undefined && er.debugMessage.message.includes("Resource temporarily unavailable")){
              er.debugMessage.message = 'Could not save changes. Please try again in a second.'
            }else if(er.debugMessage !== undefined && typeof er.debugMessage === 'string' && er.debugMessage.includes("Resource temporarily unavailable")){
              er.debugMessage = 'Could not save changes. Please try again in a second.'
            }else if(er.debugMessage !== undefined && typeof er.debugMessage !== 'string'){
              er.debugMessage = er.debugMessage.message
            }

            if(!er.severity){
              er.severity = "error"
            }
            newErrors.push(er)
          })

          let index = 0

          newState = {
              ...state,
              items: [...newErrors],
              open: true
          }
          newState.item = newState.items[index]

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