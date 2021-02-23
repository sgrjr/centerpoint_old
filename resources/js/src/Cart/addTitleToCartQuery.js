export default (variables) => {

  return {

    query:`mutation($REMOTEADDR: String!, $ISBN: String!, $QTY: Int!) {
        createCartTitle(REMOTEADDR: $REMOTEADDR, PROD_NO: $ISBN, REQUESTED: $QTY){
          user{
              vendor {
                carts(first:100){
                  paginatorInfo{
                    total
                    count
                  }
                  data{
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
                      TITLE
                      REQUESTED
                      SALEPRICE
                      coverArt
                      AUTHOR
                      AUTHORKEY
                      STATUS
                    }
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