@extends('front.layouts.master', ['pageTitle' => __('app.headings.terms-and-conditions')])

@section('body')
    <div class="w-full container mx-auto p-6">
        <div class="w-full flex items-center justify-between">
            <a href="/" class="flex items-center text-indigo-400 no-underline hover:no-underline font-bold text-2xl lg:text-4xl">
                <img class="h-8 select-none" src="{{ settings('logo.light') }}" alt="logo">
            </a>

            <div class="flex w-1/2 justify-end content-center">
                @if(auth()->check())
                    @if(auth()->user()->isAdmin())
                        <a href="{!! route('admin:dashboard') !!}" class="btn text-indigo-500 btn-link">
                            <img src="{{ auth()->user()->avatar_url }}" class="avatar avatar-xs mr-3" alt="{{ auth()->user()->name }}"/>
                            {{ auth()->user()->name }}
                        </a>
                    @else
                        <a href="{!! route('app:dashboard') !!}" class="btn text-indigo-500 btn-link">
                            <img src="{{ auth()->user()->avatar_url }}" class="avatar avatar-xs mr-3" alt="{{ auth()->user()->name }}"/>
                            {{ auth()->user()->name }}
                        </a>
                    @endif
                @else
                    <a href="{!! route('login') !!}" class="btn text-indigo-500 btn-link">
                        {{ __('app.labels.sign-in') }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white flex flex-col py-12 px-6 lg:px-8 flex-1">
        <div class="mx-auto w-full max-w-2xl">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold">{{ __('app.headings.privacy-policy') }}</h1>
            </div>

            <div class="leading-loose">
                {!! settings('privacy_policy.content') !!}
            </div>
        </div>
    </div>
@stop
