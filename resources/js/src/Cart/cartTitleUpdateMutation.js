export default (attributes) => {

  return {
    query:`mutation ($id:Int!, $REQUESTED:Int){
      updateCartTitle(id:$id, REQUESTED: $REQUESTED){
        user {
                      vendor {
                        carts(first:100){
                          paginatorInfo{
                            total
                            count
                            perPage
                          }
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
            }  
          `, 
    variables: attributes
  }
  
  };