/* NOTIFICATION TYPES AND CREATORS */
export default { 

   NOTIFICATION_DISMISS: 
   {
       type: 'NOTIFICATION_DISMISS',   
       creator: () => {
        return { type: 'NOTIFICATION_DISMISS' }
       }
   },

   NOTIFICATION_ADD_ERROR: 
   {
       type: 'NOTIFICATION_ADD_ERROR',   
       creator: (errors) => {
        return { type: 'NOTIFICATION_ADD_ERROR' , errors}
       }
   },
}