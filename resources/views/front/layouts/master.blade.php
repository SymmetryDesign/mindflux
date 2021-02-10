<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $pageTitle }} - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{!! mix('css/app.css') !!}">
    <link rel="shortcut icon" href="{!! settings('favicon') !!}" type="image/x-icon">
    <link rel="icon" href="{!! settings('favicon') !!}" type="image/x-icon">
</head>
<body class="leading-normal tracking-normal text-gray-900 flex flex-col flex-1 min-h-screen h-full">
@yield('body')

<footer class="bg-gray-50 border-t border-gray-100">
    <div class="container mx-auto p-6">
        <div class="flex-col sm:flex sm:flex-row sm:items-center sm:justify-between">
            <div>
                <ul class="flex flex-col items-center -mx-2 sm:flex sm:flex-row sm:items-start">
                    @if(settings('privacy_policy.published', false))
                        <li class="inline-flex px-2">
                            <a href="{!! route('privacy-policy') !!}" class="text-sm text-gray-500 hover:underline">
                                {{ __('app.labels.privacy-policy') }}
                            </a>
                        </li>
                    @endif

                    @if(settings('terms_and_conditions.published', false))
                        <li class="hidden sm:inline-flex px-2">
                            <span class="select-none text-sm text-gray-500">-</span>
                        </li>
                    @endif

                    @if(settings('terms_and_conditions.published', false))
                        <li class="inline-flex px-2">
                            <a href="{!! route('terms-and-conditions') !!}" class="text-sm text-gray-500 hover:underline">
                                {{ __('app.labels.terms-and-conditions') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="text-center text-sm text-gray-500 mt-2 sm:mt-0 sm:text-left">
                {{ __('app.labels.copyright') }} © {{ config('app.name') }}. {{ __('app.labels.all-rights-reserved') }}
            </div>
        </div>
    </div>
</footer>
</body>
</html>
