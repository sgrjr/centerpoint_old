export default (variables = {}) => {
  return {
  
  query:`query ($page:Int, $perPage:Int, $filters:TitlesFiltersInput){
    viewer {
      search: titles(page: $page, perPage: $perPage, filters: $filters) {
        INDEX
        ISBN
        TITLE
        PICLOC
        INVNATURE
        LISTPRICE
        defaultImage
        CAT
        AUTHOR
        FORMAT
        SOPLAN
        PUBDATE
        STATUS
        PUBLISHER
      }
    }
  }  
  `, 
  variables: variables
}

};