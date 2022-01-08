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

            let selectedCart = state.cart.selectedCart

            if(selectedCart === false || selectedCart === "NEW_UNSAVED_CART"){
                if(action.payload.viewer && action.payload.viewer.vendor && action.payload.viewer.vendor.carts.data.length >= 1){
                    selectedCart = action.payload.viewer.vendor.carts.data[0].REMOTEADDR
                } 
            }else if(!selectedCart){
                selectedCart = "NEW_UNSAVED_CART";
            }

            return {
                ...state,
                pending: false,
                
                ...action.payload.viewer,
                cart: {
                    ...state.cart,
                    selectedCart: selectedCart
                }
            }
        
        case actions.viewer.VIEWER_UPDATE_SUCCESS.type:

            newState = {
                ...state,
                pending:false
            }

            if(action.payload.viewer !== undefined && action.payload.viewer !== null && action.payload.viewer.vendor){
              newState.vendor = {...newState.vendor, ...action.payload.viewer.vendor}
            }

            if(action.payload.viewer !== undefined && action.payload.viewer !== null && action.payload.viewer.links){
                newState.application.links = action.payload.viewer.links
            }

            return newState

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
        let newVendor = false
        if(state.vendor){
            newVendor = {...state.vendor}
        }
        if(action.payload.user.vendor !== null){
            newVendor = {...newVendor, ...action.payload.user.vendor}
        }

        let newDefaultSelectedCart = false

        if(action.payload.user.vendor){
            newDefaultSelectedCart = action.payload.user.vendor.carts.data[0].REMOTEADDR
        }

        return {
            ...state,
            vendor: newVendor,
            cart: {
                ...state.cart,
                post: false,
                selectedCart: state.cart.selectedCart? state.cart.selectedCart:newDefaultSelectedCart,
                selectedTitle: false,
                pending:false,
                addToCartPending: false
            }
     
        }
  

 case actions.cart.CART_DELETE_PENDING.type:

        let sc = state.cart.selectedCart

        if(sc === action.vars.id ){
            sc = false
        }

        return {
            ...state,
            cart: {
                ...state.cart,
                selectedCart: sc,
                pending:true
            }
     
        }

    case actions.cart.CART_DELETE_SUCCESS.type:

        return {
            ...state,
            vendor: {
                ...state.vendor,
                carts: action.viewer.vendor.carts
            },
            cart: {
                ...state.cart,
                selectedCart: action.viewer.vendor.carts.data[0].REMOTEADDR,
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

    case actions.cart.CART_TITLE_ADDED_PENDING.type:

        const {ISBN, QTY, REMOTEADDR} = action.vars
        let newState = {...state}
        let newCarts = newState.vendor.carts.data.map(function(c){
                if(c.REMOTEADDR === REMOTEADDR){
                    c.items.push({
                        AUTHOR: "",
                        AUTHORKEY: "",
                        INDEX: "",
                        PROD_NO: ISBN,
                        REQUESTED: QTY,
                        SALEPRICE: "",
                        TITLE: ISBN,
                        coverArt: "",
                        id: "",
                        STATUS: ""
                        })
                
                }
                return c
            })

        newState.vendor.carts.data = newCarts
        newState.cart.addToCartPending = true
        return newState

    case actions.cart.CART_ERROR.type:
        return {
            ...state,
            cart: {
                ...state.cart,
                pending: false,
                post: false,
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
                pending: false,
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
        istate.cart.checkout.remoteaddr = action.variables.REMOTEADDR
        istate.cart.pending = true
        istate.cart.open = false
        return istate

    case actions.cart.CART_UPDATE_ERROR.type:
        let iestate = {...state}
        iestate.cart.checkout.pending = false
        iestate.cart.checkout.post = false
        return iestate

/** INOVICE END */

    case actions.cart.CART_SELECT.type:
        return {
            ...state,
            cart:{
                ...state.cart,
                selectedCart: action.cartId
            }
        }
    
        case actions.cart.SELECT_TITLE_QUANTITY.type:
            return {
                ...state,
                cart: {
                    ...state.cart,
                    selectedQuantity: parseInt(action.selectedQuantity),
                    pending: false,
                    addToCartPending: false
                }
            }
            
        case actions.cart.TOGGLE_CART.type:

            return {
                ...state,
                cart: {
                    ...state.cart,
                    open: !state.cart.open
                }
            }

        case actions.cart.CART_UPDATE_FORM.type:

            let ns = {
                ...state
            }
            let index = action.index
            let key = action.key
            ns.vendor.carts.data[index][key] = action.value
            return ns

        case actions.cart.CHECKOUT_UPDATE.type:

            let data = {...state.cart.checkout.data}
            data[action.input.name] = action.input.value

            return {
                ...state,
                cart:{
                    ...state.cart,
                    checkout:{
                        ...state.cart.checkout,
                        data: {
                            ...data
                        }
                    }
                }
            }
            
  

        case actions.cart.CART_DELETE_TITLE_SUCCESS.type:
        case actions.cart.CART_CREATE_SUCCESS.type:
            return {
                ...state,
                vendor:{
                    ...state.vendor,
                    carts:action.data.vendor.carts
                },
                cart:{
                    ...state.cart,
                    pending: false,
                    addToCartPending: false
                    
                }
            }

            case actions.cart.CART_DELETE_TITLE_PENDING.type:
                const titleIndex = action.input.data.titleIndex
                const cartId = action.input.data.cartId

                let newItems = state.vendor.carts.data.map(function(c){
                    if(c.REMOTEADDR === cartId){
                        c.items.splice(titleIndex,1)
                        return c
                    }
                    return c
                })

                return {
                    ...state,
                    cart:{
                        ...state.cart,
                        addToCartPending: true
                    }
                }

        case actions.cart.CART_CHECKOUT.type:

            return {
                ...state
            }
        
        case actions.cart.CART_UPDATE_PENDING.type:

            return {
                ...state,
                cart :{
                    ...state.cart,
                    checkout:{
                        ...state.cart.checkout,
                        data:{
                            ...state.cart.checkout.data,
                            ISCOMPLETE: true
                        }
                    }
                }
            }

        case actions.cart.CART_UPDATE_SUCCESS.type:
            
            let csns =  {
                ...state,
                pending: false,
                post: false    
            }

            csns.vendor.carts.data = csns.vendor.carts.data.map(function(c){
                if(c.id === action.payload.id){
                    return {...c, ...action.payload}
                }else{
                    return c
                }
            })

            csns.cart.checkout.data = {...action.payload}

            return csns

        case actions.cart.CART_TITLE_UPDATE_PENDING.type:
            
            let newcartstate =  {
                ...state   
            }
            let {id, REQUESTED} = action.variables;
            id = parseInt(id)
            REQUESTED = parseInt(REQUESTED)

            newcartstate.vendor.carts.data.map(function(cart){
                return cart.items.map(function(item){
                    if(item.id === id){item.REQUESTED = REQUESTED}
                    return item
                })
            })

            const items = newcartstate.cart.checkout.data.items.map(function(item){
                if(item.id === id){
                    item.REQUESTED = REQUESTED
                }

                return item
            })

            newcartstate.cart.checkout.data.items = items

            return newcartstate;
            


        case actions.cart.CART_TITLE_UPDATE_SUCCESS.type:
    
            return  {
                ...state,
                vendor: {
                    ...state.vendor,
                    ...action.payload.user.vendor
                }
            }

            
/* cart stuff end*/

        default:
            return state;
}

}

export default viewerReducer;