export default (attributes) => {

  return {
    query:`mutation ($input: UpdateCartTitleInput!){
      updateOrCreateCartTitle(input: $input){

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
                              INVNATURE
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