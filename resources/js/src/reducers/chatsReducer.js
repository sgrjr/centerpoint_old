import actions from '../actions'

const initState = {
    messages: [],
    users:[]
}


export default (state = initState, action)=>{
    let ns = null

    switch (action.type) {

         case actions.chat.MESSAGE_SEND.type:
            ns = Object.assign({}, state)
            ns.messages = [...ns.messages, ...action.payload]
            return ns;

         case actions.chat.MESSAGE_ADD_USERS.type:
            ns = Object.assign({}, state)
            ns.users = [...action.users]
            return ns;

         case actions.chat.MESSAGE_JOIN_USER.type:
            ns = Object.assign({}, state)
            ns.users.push(action.user)
            return ns;

         case actions.chat.MESSAGE_EXIT_USER.type:
            ns = Object.assign({}, state)
            ns.users = []

            state.users.map((user, i)=>{
                if(user.id != action.user.id){
                    ns.users.push(user)
                }
            })
            return ns;

        default:
            return state
      }
}