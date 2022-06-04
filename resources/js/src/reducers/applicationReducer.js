import actions from '../actions'
import applicationReducerInit from './applicationReducerInit'

const applicationReducer = (state = applicationReducerInit,action)=>{

    switch (action.type) {

        case actions.application.APP_GET.type: 
            return state

        case actions.application.APP_PENDING.type: 
        case actions.auth.AUTH_LOGOUT_PENDING.type:
            return {
                ...state,
                pending: true
            }
        case actions.application.APP_SUCCESS.type:
            return {
                ...state,
                pending: false,
                ...action.payload.application
            }
        
        case actions.application.APP_UPDATE_SUCCESS.type:
            if(action.payload.application){

                return {
                    ...state,
                    pending:false,
                    links: {
                        ...state.links,
                        drawer: action.payload.application.links.drawer
                    }
                }
            }else{
                return {
                    ...state
                }
            }            

        case actions.application.APP_ERROR.type:
         case actions.auth.AUTH_LOGOUT_ERROR.type:
            return {
                ...state,
                pending: false,
                error: action.error
            }

        case actions.search.SEARCH_UPDATE.type: 

            return {
                ...state,
                search: action.input
            }

        case actions.search.SEARCH_UPDATE_FILTER.type: 

            return {
                ...state,
                searchFilter: action.filter
            }

        case actions.auth.AUTH_LOGOUT_SUCCESS.type:
            return {
                ...state,
                pending:false,
                ...action.payload.application
            }

        case actions.form.DOWNLOAD_MARCS_SUCCESS.type:

        return  {
            ...state,
            marcLink: action.payload.zip
        }

        case actions.form.CLEAR_MARC.type:
            return {
                ...state,
                marcLink: null
            }

        case actions.application.TOGGLE_OLD_WEBSITE.type:

            return  {
                ...state,
                oldWebsite: !state.oldWebsite
            }
        
        case actions.auth.AUTH_SUCCESS.type:

            return  {
                ...state,
                ...action.payload.application
            }

        default:
            return state;
}

}

export default applicationReducer;