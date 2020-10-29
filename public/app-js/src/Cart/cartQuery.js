export default (variables) => {

  return {

    query:`query {
      viewer {
        user {
          vendor {
            carts {
              INDEX
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              REMOTEADDR
              ISCOMPLETE
              details{
                INDEX
                PROD_NO
                TITLE
                REQUESTED
                SALEPRICE
                defaultImage
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