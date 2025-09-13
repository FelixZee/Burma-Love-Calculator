@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card p-5">
      <h3 class="mb-3">Result 💕</h3>

      <p><strong>{{ $your }}</strong> ❤️ <strong>{{ $parter }}</strong></p>

      <div class="mb-3">
        <div class="d-flex justify-content-between mb-1">
          <small>Compatibility: <strong>{{ $score }}%</strong></small>
          <small>{{ $score }}/100</small>
        </div>

        <div class="progress mb-2" role="progressbar" aria-valuenow="{{ $score }}" aria-valuemin="0" aria-valuemax="100">
          <div class="progress-bar" style="width: {{ $score }}%; background: linear-gradient(90deg,#ff6b81,#ff9aa2);"></div>
        </div>

        <p class="lead">{{ $message }}</p>

        <a href="{{ route('loves.index') }}" class="btn btn-outline-success">Try Again</a>
      </div>
       <div class="card mt-3 p-3">
  <h5>Your Calculation Steps 🔍</h5>
  <p class="text-muted">
    Here's how we calculated <strong>{{ $your }}</strong> + <strong>{{ $parter }}</strong> = <strong>{{ $score }}%</strong>:
  </p>

  <div class="d-flex flex-column gap-3">
    @foreach ($steps as $index => $step)
      <div class="card shadow-sm" style="background-color: #fff7f9">
        <div class="card-body">
          <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;">
              {{ $index + 1 }}
            </div>
            <strong class="ms-2">Step {{ $index + 1 }}</strong>
          </div>

          @if ($step['type'] === 'initial')
            @foreach ($step['rows'] as $row)
              <div class="d-flex mb-2 flex-wrap">
                @foreach ($row as $num)
                  <div class="border rounded px-2 py-1 mx-1 bg-light d-flex align-items-center justify-content-center"
                       style="min-width:44px;height:36px;">
                    {{ $num }}
                  </div>
                @endforeach
              </div>
            @endforeach

          @elseif ($step['type'] === 'reduced')
            <div class="d-flex flex-wrap">
              @foreach ($step['numbers'] as $num)
                <div class="border rounded px-2 py-1 mx-1 bg-light d-flex align-items-center justify-content-center"
                     style="min-width:44px;height:36px;">
                  {{ $num }}
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</div>
      <p class="small text-muted mt-4">Note: This calculator is just for fun and entertainment purposes only 😄</p>
    </div>
  </div>
</div>
@endsection
