import actions from '../actions'
import viewerReducerInit from './viewerReducerInit'

const viewerReducer = (state = viewerReducerInit,action)=>{

    switch (action.type) {

        case actions.viewer.VIEWER_GET.type: 
            return state

        case actions.viewer.VIEWER_PENDING.type: 
        case actions.application.APP_PENDING.type: 

            return {
                ...state,
                pending: true
            }
        case actions.application.APP_UPDATE_SUCCESS.type:
        case actions.application.APP_SUCCESS.type:
        case actions.viewer.VIEWER_SUCCESS.type:
            return {
                ...state,
                pending: false,
                ...action.payload.viewer
            }
        
        case actions.viewer.VIEWER_UPDATE_SUCCESS.type:
            return {
                ...state,
                pending:false,
                user: {
                    ...state.user,
                    vendor: {...action.payload.viewer.user.vendor}
                },
                links: {
                    ...state.links,
                    drawer: action.payload.viewer.links.drawer
                }
            }

        case actions.viewer.VIEWER_ERROR.type:
            return {
                ...state,
                pending: false,
                error: action.error
            }

        case actions.auth.AUTH_PENDING.type: 
            return {
                ...state,
                pending: true
            }

        case actions.auth.AUTH_SUCCESS.type: 
            return {
                ...state,
                ...action.payload,
                pending:false
            }

        case actions.auth.AUTH_LOGOUT_SUCCESS.type: 
            return false


        case actions.auth.AUTH_ERROR.type:
            return {
                ...state,
                pending: false
            }

        case actions.form.UPLOAD_SUCCESS.type:
            return {
                ...state,
                photo: action.payload
            }

        case actions.form.UPDATE_PROFILE_IMAGE_SOURCE.type:
            return {
                ...state,
                photo: action.input
            }
            
/*cart stuff start*/
    case actions.cart.CART_SUCCESS.type:
    case actions.cart.CART_TITLE_ADDED_SUCCESS.type:
        return {
            ...state,
            vendor: {
                ...state.vendor,
                carts: action.payload.vendor.carts
            },
            cart: {
                ...state.cart,
                post: false,
                selectedCart: false,
                selectedTitle: false,
                pending:false
            }
     
        }
  
    case actions.cart.CART_DELETE_SUCCESS.type:
        return {
            ...state,
            vendor: {
                ...state.vendor,
                carts: action.payload.viewer.vendor.carts
            },
            cart: {
                ...state.cart,
                pending:false
            }
     
        }

    case actions.cart.CART_PENDING.type:
        return {
            ...state,
            cart: {
                ...state.cart,
                pending:true,
                post:false   
            }       
        }

    case actions.cart.CART_ERROR.type:
        return {
            ...state,
            cart: {
                ...state.cart,
                pending: false,
                post: false,
                selectedCart:false,
                selectedTitle: false
            }
        }

/** INOVICE START*/

case actions.cart.INVOICE_SUCCESS.type:
        return {
            ...state,
            cart: {
                ...state.cart,
                open: false,
                checkout: {
                    pending:false, 
                    post: false,
                    data: action.payload,
                    remoteaddr: action.payload.REMOTEADDR
                }  
            }
        }
        
    case actions.cart.INVOICE_PENDING.type:
        let istate = {...state}
        istate.cart.checkout.pending = true
        istate.cart.checkout.remoteaddr = action.variables.filters.REMOTEADDR
        return istate

    case actions.cart.CART_SAVE_ERROR.type:
        let iestate = {...state}
        iestate.cart.checkout.pending = false
        iestate.cart.checkout.post = false
        return iestate

/** INOVICE END */
    case actions.cart.SELECT_TITLE.type:
        return {
            ...state,
            cart: {
                ...state.cart,
                selectedTitle: action.selectedTitle,
                open: true,
                pending: false
            }
        }

    case actions.cart.SELECT_CART.type:
        return {
            ...state,
            cart:{
                ...state.cart,
                selectedCart: action.selectedCart,
                open: false,
                post: true,
                pending: false
            }
        }
    
        case actions.cart.SELECT_TITLE_QUANTITY.type:
            return {
                ...state,
                cart: {
                    ...state.cart,
                    selectedQuantity: action.selectedQuantity,
                    pending: false
                }
            }
            
        case actions.cart.TOGGLE_CART.type:

            return {
                ...state,
                cart: {
                    ...state.cart,
                    open: !state.open
                }
            }
    
        case actions.cart.TOGGLE_SIMPLE_CART.type:

            return {
                ...state,
                cart: {
                    ...state.cart,
                    open: !state.open,
                    selectedTitle: false
                }
            }

        case actions.cart.CART_UPDATE_FORM.type:

            let ns = {
                ...state
            }
            let index = action.index
            let key = action.key
            ns.vendor.carts[index][key] = action.value
            return ns

        case actions.cart.CHECKOUT_UPDATE.type:

            let chstate = Object.assign({}, state)

            chstate.cart.checkout.data[action.input.name] = action.input.value
            return chstate   

        case actions.cart.CART_DELETE_TITLE_SUCCESS.type:
        case actions.cart.CART_CREATE_SUCCESS.type:
            return {
                ...state,
                vendor:{
                    ...state.vendor,
                    carts:action.payload
                },
                cart:{
                    ...state.cart,
                    pending: false,
                    
                }
            }

            case actions.cart.CART_DELETE_TITLE_PENDING.type:

                return {
                    ...state,
                    cart:{
                        ...state.cart,
                        pending: true
                    }
                }

        case actions.cart.CART_CHECKOUT.type:

            return {
                ...state
            }
        
        case actions.cart.CART_SAVE_SUCCESS.type:
            
            let csns =  {
                ...state,
                pending: false,
                post: false    
            }

            csns.carts.map(function(c, i){
                if(c.INDEX === action.payload.INDEX){
                    return  {...c, ...action.payload}
                }else{
                    return c
                }
            })

            csns.cart.checkout.data = {...action.payload}
            return csns

        case actions.cart.CART_TITLE_UPDATE_QUANTITY_PENDING.type:
        
            let newcartstate =  {
                ...state   
            }
            const {cartIndex, titleIndex, REQUESTED} = action.variables;
            newcartstate.vendor.carts[cartIndex].details[titleIndex].REQUESTED = REQUESTED

            return newcartstate

        case actions.cart.CART_TITLE_UPDATE_QUANTITY_SUCCESS.type:
    
            return  {
                ...state,
                vendor: {
                    ...state.vendor,
                    carts: [...action.payload]
                }
            }
/* cart stuff end*/

        default:
            return state;
}

}

export default viewerReducer;