import q from '../reducers/queries'

export default (variables) => {

  if(!variables.cartsLimit) {variables['cartsLimit'] = 100}

  return {
    query:q.fragments([ 'order','orderItem'],` mutation ($id:ID, $cartsLimit:Int!){
                deleteCart(id:$id){
                      vendor {
                        carts(first:$cartsLimit){
                         data{
                         ...OrderFragment
                            items{
                              ...OrderItemFragment
                            }
                         }
                        }
                      }
                    }
            }  
          `), 
    variables: variables
  }
  
  };