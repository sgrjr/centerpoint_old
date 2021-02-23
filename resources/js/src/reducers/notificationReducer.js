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
          case actions.cart.CART_UPDATE_ERROR.type:
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

          case actions.cart.CART_DELETE_SUCCESS.type:
          return {
            ...state,
            open: true,
            items:  [{message:"Cart Deleted", severity:"success"}]
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

      case actions.cart.CART_TITLE_UPDATE_PENDING.type:
        return {
          ...state,
          open: true,
          items:  [{message:"Title Quantity Pending: " + action.variables.REQUESTED +" ...", severity:"warning"}]
        }

        case actions.cart.CART_TITLE_UPDATE_SUCCESS.type:
          return {
            ...state,
            open: true,
            items:  [{message:"Title Quantity Success: ", severity:"success"}]
          }

          case actions.cart.CART_UPDATE_PENDING.type:
            return {
              ...state,
              open: true,
              items:  [{message:"Updating Cart Changes ... ", severity:"warning"}]
            }

            case actions.cart.CART_UPDATE_SUCCESS.type:
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
              
            case actions.cart.CART_TITLE_ADDED_PENDING.type:
              return {
                ...state,
                open: true,
                items:  [{message:"Adding "+action.vars.ISBN+" to Cart ... ", severity:"warning"}]
              }

          case actions.form.DOWNLOAD_MARCS_PENDING.type:
            return {
              ...state,
              open: true,
              items: [{message:"Marcs are being zipped", severity:"success"}]
            }

          case actions.form.DOWNLOAD_MARCS_SUCCESS.type:
            return {
              ...state,
              open: true,
              items: [{message:"Marcs are ready for download.", severity:"success"}]
            }

          case actions.form.DOWNLOAD_MARCS_ERROR.type:
            return {
              ...state,
              open: true,
              items: [{message:"Marcs FAILED to be zipped.", severity:"success"}]
            }              

        default:
          return state
      }
}