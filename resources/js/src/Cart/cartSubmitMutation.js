export default (variables) => {

  return {
    query:`  mutation ($cartIndex:Int, $properties: OrderHeadInput){
                updateCart(cartIndex:$cartIndex, properties: $properties){
                          INDEX
                          KEY
                          DATE
                          PO_NUMBER
                          TRANSNO
                          REMOTEADDR
                          ISCOMPLETE
                          items{
                            INDEX
                            PROD_NO
                            TITLE
                            REQUESTED
                            SALEPRICE
                            coverArt
                            AUTHORKEY
                            url
                          }
                          invoice {
                            id
                            title
                            dates
                            headings
                            totaling{
                              subtotal
                              shipping
                              paid
                              grandtotal
                            }
                            company_logo
                            company_website
                            company_name
                            company_address
                            company_telephone
                            company_email
                            customer_name
                            customer_address
                            customer_email
                            thanks
                            invoice_memo
                            footer_memo
                          }
                        }
                      } 
          `, 
    variables: variables
  }
  
  };