@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card p-4">
      <h3 class="mb-3">Love Calculator</h3>
      <form action="{{ url('/loves/calculate') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label" style="font-size: 20px">Your Name</label>
          <input type="text" name="your" class="form-control" value="{{ old('your') }}" placeholder="Enter Your Name">
          @error('your') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" style="font-size: 20px">Partner's Name</label>
          <input type="text" name="parter" class="form-control" value="{{ old('parter') }}" placeholder="Enter Parter's Name">
          @error('parter') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-pink btn-success">Love Calculate 💖</button>
      </form>

      <hr>

      <p class="small text-muted">Note: This calculator is just for fun and entertainment purposes only 😄</p>
    </div>
  </div>
</div>
@endsection
