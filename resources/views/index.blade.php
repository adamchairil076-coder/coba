@extends('layouts.home', [
	'title' => 'Home',
	'categories' => \App\Models\Category::all()
])

@section('donation')
@foreach(\App\Models\Campaign::limit(6)->get() as $campaign)

@php
   $percentage = $campaign->goals > 0 ? ($campaign->raised / $campaign->goals) * 100 : 0;
@endphp

<div class="col-sm-6 col-lg-4">
   <div class="donation-item"
        onclick="window.location='{{ route('campaign.show', $campaign->slug) }}'"
        style="cursor: pointer; height: 100%;">

      <div class="img" style="height: 240px; overflow: hidden;">
         <img src="{{ asset('storage/'.$campaign->thumbnail) }}"
              alt="Donation"
              style="width: 100%; height: 100%; object-fit: cover;">
      </div>

      <div class="top pt-3">
         <h3>
            <a href="{{ route('campaign.show', $campaign->slug) }}"
               onclick="event.stopPropagation();">
               {{ $campaign->title }}
            </a>
         </h3>
      </div>

      <div class="inner">
         <div class="bottom">

            <div class="skill">
               <div class="skill-bar wow fadeInLeftBig" style="width: {{ min($percentage, 100) }}%">
                  <span class="skill-count4">
                     {{ $percentage >= 10 ? number_format($percentage, 0). '%' : '' }}
                  </span>
               </div>
            </div>

            <ul>
               <li class="text-dark">
                  Target: Rp.{{ number_format($campaign->goals, 0, '.', ',') }}
               </li>

               <li class="text-dark">
                  <b>{{ $campaign->deadline }}</b>
               </li>
            </ul>

            <h4>
               <span>
                  {{
                     $campaign->donations()
                        ->where('campaign_id', $campaign->id)
                        ->where('status', 'PAID')
                        ->count('id')
                  }} donatur
               </span>
            </h4>

            <a href="{{ route('campaign.show', $campaign->slug) }}"
               class="common-btn w-100 text-center mt-3"
               onclick="event.stopPropagation();">
               Donasi Sekarang
            </a>

         </div>
      </div>
   </div>
</div>

@endforeach
@endsection

@section('blog')

@forelse(\App\Models\Post::limit(6)->get() as $post)
	@include('components.home.article-card', [
		'title' => $post->title,
		'thumbnail' => $post->thumbnail,
		'date' => $post->created_at->format('d M, Y'),
		'author' => $post->author,
		'slug' => $post->slug
	])
@empty
<div class="text-center vh-100">
	<h4>Tidak ada artikel</h4>
</div>
@endforelse

@endsection