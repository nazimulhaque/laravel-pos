<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    setTimeout(function() {
              $('#msg').fadeOut();
          }, 3000);
});
</script>
</head>
<body>

@if (Session::has('success'))
<div id="msg" class="alert alert-primary">
    {{Session::get('success')}}
</div>
@endif