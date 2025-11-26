@extends('frontend.layouts.app')

@section('contents')
    <x-frontend.breadcrumb :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Flash Sale']]" />
    <div class="container mt-70">
        <div class="section-title wow animate__ animate__fadeIn animated"
            style="visibility: visible; animation-name: fadeIn;">
            <h3 class="">Flash Sale</h3>
            <div class="flash_countdown">
                <div class="deals-countdown" data-countdown="{{ date('Y/m/d', strtotime($flashSale?->sale_end)) }} 00:00:00">
                </div>
            </div>
            <div class="row mt-30">
                @foreach ($flashSaleProducts as $product)
                    <x-frontend.product-card :product="$product"  />
                @endforeach
            </div>
            <div>
                {{ $flashSaleProducts->links() }}
            </div>
        </div>
    </div>
@endsection

{{-- Complete Code --}}
