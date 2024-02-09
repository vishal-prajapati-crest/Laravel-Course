@extends('layouts.app')
<style>
  .rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
</style>
@section('content')

<h1 class="mb-10 text-2xl">Add Review for {{$book->title }}</h1>

<form method="POST" action="{{ route('books.reviews.store', ['book' => $book]) }}">
@csrf
<div class="mb-4">

  <label for="review">
    Review:
  </label>
  <textarea  @class(['input','input-error'=> $errors->has('review')]) class="input" rows=3 name="review" id="review" required>{{old('review')}}</textarea>
  @error('review')
  <p class="error-message">
    {{$message}}
  </p>
  @enderror
</div>

<div class="mb-4">

  <!-- <input class="input" type="number" name="rating" id="rating"/> -->
  <div>Rating:</div>
  @error('rating')
  <p class="error-message">
    {{$message ? 'Please rate us' : ''}}
  </p>
  @enderror
  <div class="rate">
    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Very Happy😃">5 stars</label>
    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Good🙂">4 stars</label>
    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Satisfied😐">3 stars</label>
    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Unhappy🙁">2 stars</label>
    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Very Poor😡">1 star</label>
  </div>
  
</div>
<br><br>
  <div><button class="btn" type="submit">Add</button></div>
</form>
@endsection