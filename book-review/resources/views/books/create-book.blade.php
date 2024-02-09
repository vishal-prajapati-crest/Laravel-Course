@extends('layouts.app')

@section('content')
<h1 class="mb-10 text-2xl text-center">Add New Book</h1>
  <form method="post" action="{{route('books.store')}}">
  @csrf
    <div class="mb-4">
      <label for="title">Book Title: </label>
      <input @class(['input','input-error'=> $errors->has('title')]) type="text" name="title" id="title" value="{{old('title')}}" />  
      @error('title')
        <p class="error-message">
          {{$message}}
        </p>
      @enderror    
    </div>

    <div class="mb-4">
      <label for="author">Author: </label>
      <input @class(['input','input-error'=> $errors->has('author')]) type="text" name="author" id="author" value="{{old('author')}}" />  
      @error('author')
        <p class="error-message">
          {{$message}}
        </p>
      @enderror     
    </div>

    <div><button class="btn" type="submit">Add Book</button></div>
  </form>

@endsection