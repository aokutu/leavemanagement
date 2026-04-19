<form method="POST" action ="/processform">
    @csrf
NAME 
<input type="text" name= "name1"  /> <br/> <br/>



<button type="submit">SUBMIT</button><button type="reset">RESET</button>
<br /><br />

<h1> {{$name1}}  </h1>

  @error('name1')
        <div style="color:red">{{ $message }}</div>
    @enderror


</form>