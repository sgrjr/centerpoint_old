import actions from '../actions'

const initState = {
        login: {
            email: "",
            password: "",
            errors: {
                email:"",
                password: "",
                general:""
            }
        },
        photoStaging:false,
        photo: {
            selectedFile: {},
            completed: [],
            imageSource: null,
            errors: {
                selectedFile:null
            }
        }
}

export default (state = initState, action)=>{
    let ns = null

    switch (action.type) {

        case actions.auth.AUTH_ERROR.type:
            ns = Object.assign({}, state)
            ns.login.errors.email = ""
            ns.login.errors.password = ""
            ns.login.errors.general = ""

            action.errors && action.errors.map((er)=>{
                ns.login.errors.general += " " + er.message
                if(er.debugMessage) ns.login.errors.general += ' : ' + JSON.stringify(er.debugMessage);
                if(er.extensions.category === "validation"){
                    ns.login.errors.email += er.extensions.validation["input.email"]? er.extensions.validation["input.email"].join(","):""
                    ns.login.errors.password += er.extensions.validation["input.password"]? er.extensions.validation["input.password"].join(","):""
                    ns.login.errors.email += er.extensions.validation.EMAIL? er.extensions.validation.EMAIL.join(","):""
                    ns.login.errors.password += er.extensions.validation.password? er.extensions.validation.password.join(","):""
                }
            })

            return ns;

        case actions.auth.AUTH_SUCCESS.type:
            ns = Object.assign({}, state)
            ns.login = {...initState.login}
            return ns

        case actions.form.FORM_UPDATE_SUCCESS.type:
            ns = Object.assign({}, state)
            ns[action.form][action.field] = action.input
            return ns;
        
        case actions.form.UPDATE_PROFILE_IMAGE_PENDING.type:
            ns = Object.assign({}, state)

            if(action.input === false){
                ns.photo = {
                    selectedFile: {},
                    completed: [],
                    imageSource: null,
                    errors: {
                        selectedFile:null
                    }
                }
            }else{
                ns.photo.imageSource = action.input;
            }
            
            return ns;

        default:
            return state
      }
}