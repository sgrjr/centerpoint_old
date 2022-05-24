import actions from '../actions'

const initState = {
    pending: false,
    carts: window.INITIAL_STATE.viewer.vendor? window.INITIAL_STATE.viewer.user.vendor.carts:[],
    selectedTitle: false,
    selectedCart: false,
    selectedQuantity: 1,
    open: false,
    post: false,
    checkout:{
        pending: false,
        post: false,
        remoteaddr: null,
        data: {
            ISCOMPLETE: false,
            details:[],
            invoice:{
                totaling:{
                    subtotal:0,
                    paid:0,
                    shipping:0,
                    grandtotal:0
                }
            }
        }
    }
}

const cartReducer= (state = initState,action)=>{

    switch (action.type) {
    
    case actions.cart.CART_SUCCESS.type:
    case actions.cart.CART_TITLE_ADDED_SUCCESS.type:
        return {
            ...state,
            pending: false,
            carts: action.payload.viewer.user.vendor.carts,
            post: false,
            selectedCart: false,
            selectedTitle: false     
        }
  
    case actions.cart.CART_DELETE_SUCCESS.type:
        return {
            ...state,
            pending: false,
            carts: action.payload.carts       
        }

    case actions.cart.CART_PENDING.type:
        return {
            ...state,
            pending:true,
            post:false          
        }

    case actions.cart.CART_ERROR.type:
        return {
            ...state,
            pending: false,
            post: false,
            selectedCart:false,
            selectedTitle: false
        }

/** INOVICE START*/

case actions.cart.INVOICE_SUCCESS.type:
        return {
            ...state,
            cartopen: false,
            checkout: {
                pending:false, 
                post: false,
                data: action.payload,
                remoteaddr: action.payload.REMOTEADDR
            }  
        }
        
    case actions.cart.INVOICE_PENDING.type:
        let istate = {...state}
        istate.checkout.pending = true
        istate.checkout.remoteaddr = action.variables.filters.REMOTEADDR
        return istate

    case actions.cart.CART_SAVE_ERROR.type:
        let iestate = {...state}
        iestate.checkout.pending = false
        iestate.checkout.post = false
        return iestate

/** INOVICE END */
    case actions.cart.SELECT_TITLE.type:
        return {
            ...state,
            selectedTitle: action.selectedTitle,
            open: true,
            pending: false
        }

    case actions.cart.SELECT_CART.type:
        return {
            ...state,
            selectedCart: action.selectedCart,
            open: false,
            post: true,
            pending: false
        }
    
        case actions.cart.SELECT_TITLE_QUANTITY.type:
            return {
                ...state,
                selectedQuantity: action.selectedQuantity,
                pending: false
            }
            
        case actions.cart.TOGGLE_CART.type:

            return {
                ...state,
                cartopen: !state.cartopen
            }
    
        case actions.cart.TOGGLE_SIMPLE_CART.type:

            return {
                ...state,
                open: !state.open,
                selectedTitle: false
            }

        case actions.cart.CART_UPDATE_FORM.type:

            let ns = {
                ...state
            }
            let index = action.index
            let key = action.key
            ns.carts[index][key] = action.value
            return ns

        case actions.cart.CHECKOUT_UPDATE.type:

            let chstate = Object.assign({}, state)

            chstate.checkout.data[action.input.name] = action.input.value
            return chstate   

        case actions.cart.CART_DELETE_TITLE_SUCCESS.type:
        case actions.cart.CART_CREATE_SUCCESS.type:
            return {
                ...state,
                pending: false,
                carts: action.payload
            }

            case actions.cart.CART_DELETE_TITLE_PENDING.type:

                return {
                    ...state,
                    pending: true
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

            csns.checkout.data = {...action.payload}
            return csns

        case actions.cart.CART_TITLE_UPDATE_QUANTITY_PENDING.type:
        
            let newcartstate =  {
                ...state   
            }
            const {cartIndex, titleIndex, REQUESTED} = action.variables;
            newcartstate.carts[cartIndex].details[titleIndex].REQUESTED = REQUESTED

            return newcartstate

        case actions.cart.CART_TITLE_UPDATE_QUANTITY_SUCCESS.type:
    
            return  {
                ...state,
                carts: [...action.payload]
            }

        default:
            return state;
}
}

export default cartReducer;