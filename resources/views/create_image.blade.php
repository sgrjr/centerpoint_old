<html lang="en">
<head>
  <title>Center Point Image Uploader</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
  
  <div class="container">
  @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div> 
        @endif
        @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
    <h3 class="jumbotron">Center Point Large Print Images</h3>
  <form method="post" action="{{url('/img')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
          <input type="file" name="filename" class="form-control">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
          <button type="submit" class="btn btn-success" style="margin-top:10px">Upload Image</button>
          </div>
        </div>
        @if($image)
   	    <div class="row">
         <div class="col-sm-12">
              <img src="/img/original/{{$image->filename}}" />
        </div>
   		</div>
        @endif 
        
        @if($images)
        <hr/>
        <div class="row">
        @foreach($images AS $img)
          <div class="col-md-2">
              <img style="width:200px" src="/img/small/{{$img->filename}}"  />
          </div>
        
       @endforeach
       </div>
        @endif 
  </form>
  </div>
</body>
</html>