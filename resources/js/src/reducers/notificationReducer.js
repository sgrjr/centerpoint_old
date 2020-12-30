import actions from '../actions'
  
  const initState = {
    open: true,
    items: [
      {message:"Welcome to Centerpoint Large Print!", severity:"info"}
    ]
}

//The reducer is a pure function that takes the previous state and an action, and 
// returns the next state.

export default (state = initState,action)=>{

    switch (action.type) {
        case actions.notification.NOTIFICATION_DISMISS.type:

          return Object.assign({}, state, {
            open: false,
            items: []
          })

        case actions.notification.NOTIFICATION_ADD_ERROR.type:

          return Object.assign({}, state, {
            open: true,
            items: action.errors
          })

        case actions.auth.AUTH_ERROR.type:
        case actions.admin.ADMIN_ERROR.type:
          return {
              ...state,
              open: action.errors? true:false,
              items: action.errors?  action.errors:[]
          }

          case actions.cart.CART_ERROR.type:
            return {
                ...state,
                open: action.errors? true:false,
                items: action.errors? action.errors:[]
            }

        case actions.cart.CART_SUCCESS.type:
          return {
            ...state,
            open: true,
            items:  [{message:"Cart loaded", severity:"success"}]
          }
          case actions.cart.CART_TITLE_ADDED_SUCCESS.type:
            return {
              ...state,
              open: true,
              items: [{message:"Successfully added to cart.", severity:"success"}]
            }
          
            case actions.cart.INVOICE_ERROR.type:
              return {
                  ...state,
                  open: action.errors? true:false,
                  items: action.errors? action.errors:[]
              }

              case actions.cart.INVOICE_SUCCESS.type:
                return {
                  ...state,
                  open: true,
                  items:  [{message:"Invoice loaded", severity:"success"}]
                }

      case actions.cart.CART_TITLE_UPDATE_QUANTITY_PENDING.type:
        return {
          ...state,
          open: true,
          items:  [{message:"Title Quantity Pending: " + action.variables.REQUESTED +" ...", severity:"warning"}]
        }

        case actions.cart.CART_TITLE_UPDATE_QUANTITY_SUCCESS.type:
          return {
            ...state,
            open: true,
            items:  [{message:"Title Quantity Success: ", severity:"success"}]
          }

          case actions.cart.CART_SAVE_PENDING.type:
            return {
              ...state,
              open: true,
              items:  [{message:"Updating Cart Changes ... ", severity:"warning"}]
            }

            case actions.cart.CART_SAVE_SUCCESS.type:
              return {
                ...state,
                open: true,
                items:  [{message:"Changes were updated.", severity:"success"}]
              }

            case actions.cart.CART_CREATE_PENDING.type:
              return {
                ...state,
                open: true,
                items:  [{message:"Creating cart ... ", severity:"warning"}]
              }
  
            case actions.cart.CART_CREATE_SUCCESS.type:
              return {
                ...state,
                open: true,
                items:  [{message:"Cart was sucessfully created.", severity:"success"}]
              }
              
              

        default:
          return state
      }
}