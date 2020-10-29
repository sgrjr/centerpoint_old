
/* SEARCH TYPES AND CREATORS */ 
export default { 
  SEARCH_UPDATE_FILTER: 
      {
          type: 'SEARCH_UPDATE_FILTER',   
          creator: (filter) => {
              return { type: 'SEARCH_UPDATE_FILTER', filter: filter }
          }
  },

  SEARCH_UPDATE: 
  {
      type: 'SEARCH_UPDATE',   
      creator: (input) => {
          return { type: 'SEARCH_UPDATE', input: input }
      }
  }
  
}