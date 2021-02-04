export default {
	pending: false,
    
    	cart: {
		    pending: false,
		    selectedTitle: false,
		    selectedCart: false,
		    selectedQuantity: 1,
		    open: false,
		    post: false,
		    checkout:{
		        pending: false,
		        post: false,
		        remoteaddr: null,
		        data: {
		            ISCOMPLETE: false,
		            PO_NUMBER:"",
		            items:[],
		            invoice:{
		                totaling:{
		                    subtotal:0,
		                    paid:0,
		                    shipping:0,
		                    grandtotal:0
		                }
		            }
		        }
		    }
		}
    
}