<style>
/* remember to define visible focus styles! 
:focus{
    outline:?????;
} */

/* ANIMATED BOOK  */

.color1{color:#1BBC9B}/*MOUNTAIN MEADOW*/
.color2{color:#C0392B/*TALL POPPY*/}

/* Product Layout */

.products {
	display: flex;
	flex-wrap: wrap;
}

.products .card {
	color: #013243; /*SHERPA BLUE*/
	width: 250px;
	height: 375px;
	background: #e0e1dc;
	transform-style: preserve-3d;
/*	transform: translate(-50%,-50%) perspective(2000px);*/
	transform: perspective(2000px) rotate(-5deg);
/*	box-shadow: inset 300px 0 50px rgba(0,0,0,.5), 20px 0 60px rgba(0,0,0,.5);*/
	box-shadow: 5px 10px #000000d1;
	transition: 1s;
	display: flex;
	flex-direction: column;
	flex: 1 16%;
	margin:15px;
	/* box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.25);*/
}

.products .card:hover {
	/*transform: translate(-50%,-50%) perspective(2000px) rotate(15deg) scale(1.2);*/
	transform: perspective(2000px) rotate(0deg) scale(1.2);
	box-shadow: inset 20px 0 50px rgba(0,0,0,.5), 0 10px 100px rgba(0,0,0,.5);
	z-index: 100;
}
/*
.products .card:before {
	content:'';
	top: -5px;
	left: 0;
	width: 100%;
	height: 5px;
	background: #BAC1BA;
	transform-origin: bottom;
	transform: skewX(-45deg);
}

.products .card:after {
	content: '';
	top: 0;
	right: -5px;
	width: 5px;
	height: 100%;
	background: #92A29C;
	transform-origin: left;
	transform: skewY(-45deg);
}
*/
.products .card .imgBox {
	width: 100%;
	height: 100%;
	position: relative;
	transform-origin: left;
	transition: .7s;
}

.products .card .bark {
	position: absolute;
	background: #e0e1dc;
	width: 100%;
	height: 100%;
	opacity: 0;
	transition: .7s;
}

.products .card .imgBox img {
	width: 100%;
	height:100%;
}

.products .card:hover .imgBox {
	transform: rotateY(-135deg);
}

.products .card:hover .bark {
	opacity: 1;
	transition: .6s;
  box-shadow: 300px 200px 100px rgba(0, 0, 0, .4) inset;
}

.products .card .details {
	position: absolute;
	top: 0;
	left: 0;
	box-sizing: border-box;
	padding: 0 0 0 10px;
	z-index: -1;
	margin-top: 50px;
}

.products .card .details p {
	font-size: 15px;
	line-height: 30px;
	transform: rotate(0deg);
	padding: 20px;
}

.products .card .details h4 {
	text-align: center;
}

.text-right {
	text-align: right;
}

@media ( max-width: 920px ) {
	
	.products .card {
		flex: 1 21%;
	}
	
	.products .card:first-child, 
	.products .card:nth-child(2) {
		flex: 2 46%;
	}
	
}

@media ( max-width: 600px ) {
	
	.products .card {
		flex: 1 46%;
	}
	
}

</style>

<div class="container" style="clear:both; display:block;">

   <section class="products">

        @foreach($titles AS $title)

<!--
        <div class="product-card">
            <div class="product-image">
                 <a href={{url("/isbn/".$title->isbn)}} class="card-link">
                    <img src={{$title->img}} alt="Card image cap">
                 </a>
            </div>
            <div class="product-info">
                <h6>$ {{$title->listprice}}</h6>
            </div>
        </div>
-->
<!-- ANIMATED EXAMPLE -->
<a href={{url("/isbn/".$title->isbn)}} class="card-link">
    <div class="card">
        <div class="imgBox">
            <div class="bark"></div>
            <img src={{$title->img}}>
        </div>
        
        <div class="details">
            <h4 class="color1">{{$title->title}}</h2>
            <h4 class="color2 margin">$ {{$title->listprice}}</h3>

            <p>a brief description of title will go here</p>
                <br />
 
            <p class="text-right">-- {{$title->afirst}} {{$title->alast}}</p>
        </div>
    
    </div>
</a>
        @endforeach
        
    </section>
    
</div>