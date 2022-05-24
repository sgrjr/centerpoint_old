export default (variables = {}) => {
    return {
    query:`query{
      viewer {
        titlelists{
          cp{
            INDEX
            ISBN
            TITLE
            PICLOC
            INVNATURE
            LISTPRICE
            defaultImage
          }
          advanced {
            INDEX
            ISBN
            TITLE
            PICLOC
            INVNATURE
            LISTPRICE
            defaultImage
            PUBDATE
          }
          trade{
            INDEX
            ISBN
            TITLE
            PICLOC
            INVNATURE
            LISTPRICE
            defaultImage
          }
        }
       
      }
    }  
    `, 
    variables: variables
  }
};