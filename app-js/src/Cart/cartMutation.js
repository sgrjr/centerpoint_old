export default (variables) => {

  return {

    query:`  mutation ($cartIndex:Int, $properties: OrderHeadInput){
                updatecartpreferences(cartIndex:$cartIndex, properties:$properties){
                  INDEX
                  KEY
                  DATE
                  PO_NUMBER
                  REMOTEADDR
                  ISCOMPLETE
                }
            }  
          `, 
    variables: variables
  }
  
  };