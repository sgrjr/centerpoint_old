export default (variables) => {

  return {

    query:`mutation($input: UpdateCartTitleInput!) {
        updateOrCreateCartTitle(input: $input){

              vendor {
                carts(first:12){
                  paginatorInfo{
                    total
                    count
                  }
                  data{
                    id
                    INDEX
                    KEY
                    DATE
                    PO_NUMBER
                    TRANSNO
                    REMOTEADDR
                    items{
                      id
                      INDEX
                      PROD_NO
                      title
                      REQUESTED
                      SALEPRICE
                      coverArt
                      AUTHOR
                      AUTHORKEY
                      STATUS
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