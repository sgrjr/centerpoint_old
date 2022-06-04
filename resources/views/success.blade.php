    <style>
      .hideit {
        display:none;
      }
    </style>

    <div id="temp" class="hideit" style="padding:30px; margin:30px; border: solid 2px green;">

      <p>Success! Your order was successfuly submitted for processing. 
      <div class="hideit" id="counter">5</div>
    </div> 

    <script>
        
var callback = function(){
          setInterval(function() {
              var div = document.getElementById("temp");
              var ctr = document.getElementById("counter");

               var count = ctr.textContent * 1 - 1;
              
              ctr.textContent = count;

              if (count <= 0) {
                ctr.textContent = 0;
                  //window.location.replace("/");
                  div.className = "hideit";

              }else{
                div.className = "";
              }
          }, 1000);
};

if (
    document.readyState === "complete" ||
    (document.readyState !== "loading" && !document.documentElement.doScroll)
) {
  callback();
} else {
  document.addEventListener("DOMContentLoaded", callback);
}
      </script>