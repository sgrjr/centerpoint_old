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

        case actions.auth.AUTH_SUCCESS.type: 
            return {
                ...state,
                ...action.payload
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
                user: {
                    ...state.user,
                    photo: action.payload
                }
            }

        case actions.form.UPDATE_PROFILE_IMAGE_SOURCE.type:
            return {
                ...state,
                user: {
                    ...state.user,
                    photo: action.input
                }
            }
            
        default:
            return state;
}

}

export default viewerReducer;