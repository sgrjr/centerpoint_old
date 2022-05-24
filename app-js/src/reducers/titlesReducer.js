import actions from '../actions'
import titlesReducerInit from './titlesReducerInit'

export default (state = titlesReducerInit,action)=>{

    switch (action.type) {

        case actions.titles.TITLES_INCREMENT_PERPAGE.type: 
        return {
            ...state,
            pagination: {
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

            let lists = {}

            if(action.payload.viewer.titlelists == null){
                lists = Object.entries(action.payload.viewer)
            }else{
                lists = Object.entries(action.payload.viewer.titlelists)
            }
            
            return {
                ...state,
                queried: state.queried+1,
                pending: false,
                lists: lists,
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
                    title: action.payload.viewer.title,
                    titleGetUserData: action.payload.viewer.title.user === undefined,
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