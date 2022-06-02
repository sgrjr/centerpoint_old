export default (variables) => {

  return {
    query:`  mutation ($id:Int!){
      deleteCartTitle(id: $id){
                      vendor {
                        carts (first:12){
                         data{
                          id
                           INDEX
                            KEY
                            DATE
                            PO_NUMBER
                            TRANSNO
                            REMOTEADDR
                            ISCOMPLETE
                            items{
                              id
                              INDEX
                              PROD_NO
                              TITLE
                              REQUESTED
                              SALEPRICE
                              coverArt
                              AUTHOR
                              AUTHORKEY
                              url
                              INVNATURE
                            }
                         }
                        }
                      }
                    
                  }
            }  
          `, 
    variables: variables
  }
  
  };