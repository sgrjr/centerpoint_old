import actions from '../actions'
import titlesReducerInit from './titlesReducerInit'

export default (state = titlesReducerInit,action)=>{

    switch (action.type) {

        case actions.titles.TITLES_INCREMENT_PERPAGE.type: 
        return {
            ...state,
            pagination: {
                page: 1,
                perPage: state.pagination.perPage+15
            }
        }

        case actions.titles.TITLES_PENDING.type: 

            var l = []

            if(action.query.keep){
                l = state.lists 
            }

            return {
                ...state,
                pending: true,
                lists:l,
                errors:[]
            }

        case actions.titles.TITLES_SUCCESS.type:

            return {
                ...state,
                queried: state.queried+1,
                pending: false,
                lists: Object.entries(action.payload),
                errors:[]
            }
        case actions.titles.TITLES_ERROR.type:
            return {
                ...state,
                pending: false,
                errors: action.errors
            }

            //single title

            case actions.titles.TITLE_PENDING.type: 
            return {
                ...state,
                titlepending: true,
                titleGetUserData: false,
                errors:[]
            }
    
            case actions.titles.TITLE_SUCCESS.type:
    
                return {
                    ...state,
                    queried: state.queried+1,
                    titlepending: false,
                    title: action.payload.title,
                    titleGetUserData: action.payload.title.user === undefined,
                    errors:[]
                }

            case actions.titles.TITLE_ERROR.type:
                return {
                    ...state,
                    titlepending: false,
                    errors: action.errors
                }
        default:
            return state;
}

}