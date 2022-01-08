import actions from '../actions'

const initState = {
        login: {
            email: "",
            password: "",
            errors: {
                email:null,
                password: null
            }
        },
        photo: {
            selectedFile: {},
            completed: [],
            imageSource: null,
            errors: {
                selectedFile:null
            }
        }
}

export default (state = initState,action)=>{

    switch (action.type) {

        case actions.form.FORM_UPDATE_SUCCESS.type:
            let ns = Object.assign({}, state)
            ns[action.form][action.field] = action.input
            return ns;
        
        case actions.form.UPDATE_PROFILE_IMAGE_SOURCE.type:
            let ns1 = Object.assign({}, state)
            ns1.photo.imageSource = action.input
            return ns1;

        default:
            return state
      }
}