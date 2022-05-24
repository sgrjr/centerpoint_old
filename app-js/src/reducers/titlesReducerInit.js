const TITLE = Object.assign({}, window.INITIAL_STATE.viewer.title)

export default {
        queried: 0,
        pending: false,
        errors: [],
        pagination: {
                page: 1,
                perPage: 10
        },
        lists:  window.INITIAL_STATE.viewer.titles? window.INITIAL_STATE.viewer.titles:undefined  ,
        title: TITLE? TITLE:undefined,
        titlepending: false,
        titleGetUserData: TITLE && TITLE.user === undefined? false:true
}