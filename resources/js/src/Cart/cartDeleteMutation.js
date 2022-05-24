export default (variables) => {

  return {
    query:`  mutation ($id:ID){
                deleteCart(id:$id){
                      vendor {
                        carts(first:100){
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