@extends('layouts.app')

@section('content')
<div class="jumbotron">
    <div class="container">
        {{-- <h1 class="display-4">AsicSeller.com</h1> --}}
        <p class="lead">First P2P plathform for selling mine hardware and accesories, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <a class="btn btn-success btn-lg" href="{{ route('products.index') }}" role="button">Buy now!</a>
    </div>
</div>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">
      <div class="col-md-4">
        <h2>World Wide</h2>
        <p>Will you do the same for me? It's time to face the music I'm no longer your muse. Heard it's beautiful, be the judge and my girls gonna take a vote. I can feel a phoenix inside of me. Heaven is jealous of our love, angels are crying from up above. Yeah, you take me to utopia.</p>
      </div>
      <div class="col-md-4">
        <h2>Free</h2>
        <p>Standing on the frontline when the bombs start to fall. Heaven is jealous of our love, angels are crying from up above. Can't replace you with a million rings. Boy, when you're with me I'll give you a taste. There’s no going back. Before you met me I was alright but things were kinda heavy. Heavy is the head that wears the crown.</p>
      </div>
      <div class="col-md-4">
        <h2>Heading</h2>
        <p>Playing ping pong all night long, everything's all neon and hazy. Yeah, she's so in demand. She's sweet as pie but if you break her heart. But down to earth. It's time to face the music I'm no longer your muse. I guess that I forgot I had a choice.</p>
      </div>
    </div>

    <hr>

  </div>
@endsection
