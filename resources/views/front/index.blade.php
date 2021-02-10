@extends('front.layouts.master', ['pageTitle' => __('app.headings.home')])

@section('body')
    <div class="sm:h-screen bg-right bg-cover" style="background-image: url('svg/landing-bg.svg')">
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

        <div class="container pt-24 md:pt-48 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center">
            <div class="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden">
                <h2 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 text-center sm:text-left sm:text-5xl sm:leading-none md:text-6xl">
                    {{ settings('hero.heading') }}
                </h2>

                <p class="mt-3 text-base text-gray-500 text-center sm:text-left sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                    {{ settings('hero.subheading') }}
                </p>

                <div class="mt-8 sm:flex sm:justify-center lg:justify-start">
                    <div class="rounded-md shadow">
                        <a href="{!! route('register') !!}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                            {{ __('app.labels.get-started') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-full mt-12 sm:mt-0 xl:w-3/5 py-6 overflow-y-hidden">
                <img class="w-5/6 mx-auto lg:mr-0 select-none h-72" src="{{ settings('hero.image') }}" alt="cover">
            </div>
        </div>
    </div>

    <div class="py-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <p class="text-base leading-6 text-indigo-600 font-semibold tracking-wide uppercase">{{ __('app.labels.features') }}</p>
                <h3 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                    {{ settings('features.heading') }}
                </h3>

                <p class="mt-4 max-w-2xl text-xl leading-7 text-gray-500 lg:mx-auto">
                    {{ settings('features.subheading') }}
                </p>
            </div>

            <div class="mt-10">
                <ul class="md:grid md:grid-cols-2 md:col-gap-8 md:row-gap-10">
                    @foreach($features as $feature)
                        <li class="mb-6 sm:mb-0">
                            <div class="flex">
                                <div>
                                    <h5 class="text-lg leading-6 font-medium text-gray-900">{{ $feature->title }}</h5>
                                    <p class="mt-2 text-base leading-6 text-gray-500">
                                        {{ $feature->description }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="lg:text-center mt-20">
                <p class="text-base leading-6 text-indigo-600 font-semibold tracking-wide uppercase">{{ __('app.labels.pricing') }}</p>
                <h3 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                    {{ settings('pricing.heading') }}
                </h3>

                <p class="mt-4 max-w-2xl text-xl leading-7 text-gray-500 lg:mx-auto">
                    {{ settings('pricing.subheading') }}
                </p>
            </div>

            <div class="flex flex-wrap mt-10 mx-0 sm:-mx-6">
                @foreach($plans as $plan)
                    <div class="w-full sm:w-1/3 px-0 sm:px-6 mb-6 sm:mb-0">
                        <div class="flex flex-col h-full rounded-lg bg-white sm:mb-0 mb-10 @if($plan->is_featured) border-2 border-indigo-600 @else border-2 border-gray-200 @endif">
                            <div class="px-10 pt-10">
                            <span class="bg-indigo-100 text-indigo-700 rounded-full font-medium px-6 py-1 text-base badge-indigo text-uppercase">
                                {{ $plan->name }}
                            </span>
                            </div>

                            <div class="mt-5 px-10">
                                <span class="text-5xl font-bold">${{ $plan->price }}</span>
                                <span class="text-xl font-bold text-gray-500">/mo</span>
                            </div>

                            <div class="px-10 mt-3 pb-10">
                                <p class="text-lg leading-7 text-gray-500">{{ $plan->description }}</p>
                            </div>

                            <div class="p-10 mt-auto bg-gray-100 rounded-b-lg">
                                <ul class="flex flex-col">
                                    <li class="mt-1">
                                    <span class="flex items-center text-green-500">
                                        <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/>
                                        </svg>

                                        <span class="text-gray-700">
                                            @if($plan->disk_space === null)
                                                {{ __('app.labels.unlimited-disk-space') }}
                                            @else
                                                {{ $plan->disk_space }} {{ __('app.labels.mb-disk-space') }}
                                            @endif
                                        </span>
                                    </span>
                                    </li>

                                    <li class="mt-1">
                                    <span class="flex items-center text-green-500">
                                        <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/>
                                        </svg>

                                        <span class="text-gray-700">
                                            @if($plan->max_projects === null)
                                                {{ __('app.labels.unlimited-projects') }}
                                            @else
                                                {{ $plan->max_projects }} {{ __('app.labels.projects') }}
                                            @endif
                                        </span>
                                    </span>
                                    </li>

                                    <li class="mt-1">
                                    <span class="flex items-center text-green-500">
                                        <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/>
                                        </svg>

                                        <span class="text-gray-700">
                                            @if($plan->max_users_per_project === null)
                                                {{ __('app.labels.unlimited-users-per-project') }}
                                            @else
                                                {{ $plan->max_users_per_project }} {{ __('app.labels.users-per-project') }}
                                            @endif
                                        </span>
                                    </span>
                                    </li>
                                </ul>

                                <div class="mt-8">
                                    <a href="{!! route('register') !!}" class="btn btn-xl btn-indigo btn-block">
                                        {{ __('app.labels.get-started') }} @if($plan->trial_days) - {{ $plan->trial_days }} {{ __('app.labels.trial-days') }} @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
