import actions from '../actions'
import adminReducerInit from './adminReducerInit'

const admin = (state = adminReducerInit,action)=>{
    const date = new Date();

    switch (action.type) {
      
        case actions.titles.TITLES_PENDING.type:
        case actions.titles.TITLE_PENDING.type:
        case actions.cart.CART_PENDING.type:
        case actions.viewer.VIEWER_PENDING.type:
            return {
                ...state,
                pending:true,
                progress: {
                    start: date.getTime(),
                    end: date.getTime()
                }
            }

        case actions.titles.TITLES_SUCCESS.type:
        case actions.titles.TITLES_ERROR.type:
        case actions.titles.TITLE_SUCCESS.type:
        case actions.titles.TITLE_ERROR.type:
        case actions.cart.CART_SUCCESS.type:
        case actions.cart.CART_ERROR.type:
        case actions.viewer.VIEWER_SUCCESS.type:
        case actions.viewer.VIEWER_ERROR.type:
            return {
                ...state,
                pending: false,
                progress: {
                    ...state.progress,
                    end: date.getTime()
                }
            }

        case actions.admin.ADMIN_PENDING.type: 
            return {
                ...state,
                pending: true,
                progress: {
                    start: date.getTime(),
                    end: 0
                }
            }

        case actions.admin.ADMIN_SUCCESS.type:
            return {
                ...state,
                pending: false,
                data: {
                    ...action.payload
                },
                progress: {
                    ...state.progress,
                    end: date.getTime()
                }
                
            }

        case actions.admin.ADMIN_ERROR.type:
            return {
                ...state,
                pending: false,
                errors: action.errors
            }
        
        case actions.admin.UPDATE_ADMIN_QUERY.type:
            return {
                ...state,
                adminQuery: {
                    ...state.adminQuery,
                    query: action.value
                }
            }

        default:
            return state;
}

}

export default admin;