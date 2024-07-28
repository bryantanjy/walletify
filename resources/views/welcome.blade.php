<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Walletify</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
</head>

<body>
    <nav class="bg-white border-gray-200 fixed w-full z-20 top-0 left-0 border-b">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('images/walletify-logo.png') }}" class="h-12 mr-3" alt="Walletify" />

            </a>
            @if (Route::has('login'))
                <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                    <ul
                        class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white ">
                        @auth
                            <li>
                                <a href="{{ url('/dashboard') }}"
                                    class="font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-200">Dashboard</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}"
                                    class="font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-200">Login</a>
                            </li>

                            @if (Route::has('register'))
                                <li>
                                    <a href="{{ route('register') }}"
                                        class="font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-200">Register</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            @endif
        </div>
    </nav>
    <div class="flex fixed top-20 left-0 z-10 justify-center "
        style="background-color:aliceblue; height:100%; width:100%">
        <div class="flex items-center justify-center " style="width:40%;">
            <div class="ml-5" style="height:500px;position:absolute;">
                <h1 class="justify-center " style="font-size: 42px; font-weight:bold">Tracking Your Finance Now</h1>
                <p>Monitor your daily expenses, income, track your budget to help you spent your money wisely</p>
                <button class="flex items-center bg-black rounded mt-5 mx-auto">
                    <a href="{{ route('register') }}"
                        class="ml-6 mr-6 mb-1 mt-1 font-semibold text-white hover:text-gray-400">Register</a>
                </button>
            </div>
        </div>
        <div class="flex items-center justify-center" style="width:60%">
            <svg xmlns="http://www.w3.org/2000/svg" width="768.47" height="467.54" viewBox="0 0 768.47 467.54"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect x="2" y="36.39" width="766.47" height="2" fill="#dedfe0" />
                <path
                    d="m56.15,20.67H11.84c-5.7,0-10.34-4.64-10.34-10.34S6.14,0,11.84,0h44.32c5.7,0,10.34,4.64,10.34,10.34s-4.64,10.34-10.34,10.34h0Z"
                    fill="#dedfe0" />
                <rect x="2" y="119.06" width="766.47" height="2" fill="#dedfe0" />
                <path
                    d="m56.15,103.34H11.84c-5.7,0-10.34-4.64-10.34-10.34s4.64-10.34,10.34-10.34h44.32c5.7,0,10.34,4.64,10.34,10.34s-4.64,10.34-10.34,10.34h0Z"
                    fill="#dedfe0" />
                <rect x="2" y="201.72" width="766.47" height="2" fill="#dedfe0" />
                <path
                    d="m56.15,186.01H11.84c-5.7,0-10.34-4.64-10.34-10.34s4.64-10.34,10.34-10.34h44.32c5.7,0,10.34,4.64,10.34,10.34s-4.64,10.34-10.34,10.34h0Z"
                    fill="#dedfe0" />
                <path d="m276,39.39H2c-1.1,0-2-.9-2-2s.9-2,2-2h274c1.1,0,2,.9,2,2s-.9,2-2,2Z" fill="#6c63ff" />
                <path d="m419.05,122.06H2c-1.1,0-2-.9-2-2s.9-2,2-2h417.05c1.1,0,2,.9,2,2s-.9,2-2,2Z" fill="#6c63ff" />
                <path d="m139,204.72H2c-1.1,0-2-.9-2-2s.9-2,2-2h137c1.1,0,2,.9,2,2s-.9,2-2,2Z" fill="#6c63ff" />
                <g>
                    <polygon points="577.06 164.66 560.51 170.3 560.24 146.39 575.31 146.22 577.06 164.66"
                        fill="#f3a3a6" />
                    <circle cx="562.19" cy="136.43" r="16.56" fill="#f3a3a6" />
                    <path
                        d="m566.71,134.74c-2.77-.05-4.62-2.83-5.73-5.38s-2.25-5.47-4.82-6.5c-2.11-.84-5.75,5.03-7.43,3.5-1.75-1.6-.15-9.94,1.67-11.45,1.82-1.51,4.33-1.83,6.69-1.97,5.77-.33,11.57.07,17.24,1.19,3.5.69,7.12,1.75,9.67,4.25,3.23,3.17,4.1,8,4.38,12.52.29,4.62.07,9.47-2.13,13.55-2.21,4.07-6.88,7.11-11.41,6.13-.48-2.45-.05-4.97.1-7.47.15-2.49-.07-5.18-1.61-7.15s-4.8-2.72-6.55-.94"
                        fill="#2f2e43" />
                    <path
                        d="m587.14,140.25c1.64-1.23,3.61-2.27,5.65-2.04,2.21.24,4.09,2.04,4.68,4.18.59,2.14-.02,4.51-1.36,6.28-1.34,1.77-3.35,2.95-5.49,3.55-1.24.35-2.59.5-3.78,0-1.75-.73-2.71-2.94-2.05-4.72"
                        fill="#2f2e43" />
                    <g>
                        <path id="uuid-c8983f9d-ef50-4d77-8f7b-49f8a94dcf30-69"
                            d="m525.53,296.7c-1.04,5.45,1.03,10.4,4.64,11.05,3.6.65,7.37-3.25,8.41-8.7.45-2.17.35-4.42-.29-6.55l12.74-85.41-17.16-3.03-5.65,86.63c-1.38,1.77-2.31,3.83-2.69,6.02h0Z"
                            fill="#f3a3a6" />
                        <path
                            d="m560.21,159.33l-11.69.13c-8.25,1.34-10.45,5.78-12.23,13.94-2.73,12.45-6.21,29.04-5.48,29.27,1.17.38,21.17,9.52,31.29,7.26l-1.89-50.6h0Z"
                            fill="#6c63ff" />
                    </g>
                    <rect x="559.12" y="430.83" width="15.56" height="22.07"
                        transform="translate(-4.9 6.36) rotate(-.64)" fill="#f3a3a6" />
                    <path
                        d="m544.2,466.56c-1.64.02-3.09,0-4.19-.09-4.14-.33-8.11-3.34-10.12-5.1-.9-.79-1.2-2.07-.75-3.17h0c.32-.79.98-1.39,1.8-1.64l10.89-3.24,17.55-12.13.2.35c.08.13,1.85,3.24,2.45,5.35.23.8.18,1.47-.15,1.99-.23.36-.55.57-.81.7.32.33,1.33,1,4.43,1.46,4.51.67,5.42-4.02,5.45-4.22l.03-.16.13-.09c2.13-1.41,3.44-2.05,3.9-1.92.29.08.76.22,2.18,12.94.13.4,1.06,3.32.48,6.13-.63,3.06-13.96,2.15-16.62,1.94-.08.01-10.04.83-16.87.9h.02,0Z"
                        fill="#2f2e43" />
                    <rect x="610.24" y="415.35" width="15.56" height="22.07"
                        transform="translate(-132.35 400.01) rotate(-32.59)" fill="#f3a3a6" />
                    <path
                        d="m601.65,462.89c-1.83.02-3.51-.18-4.71-.38-1.18-.2-2.11-1.12-2.31-2.3h0c-.15-.85.1-1.7.66-2.34l7.52-8.51,8.47-19.58.36.19c.13.07,3.28,1.77,4.91,3.24.62.56.93,1.15.93,1.77,0,.43-.16.78-.32,1.02.45.11,1.66.14,4.53-1.11,4.18-1.82,2.47-6.28,2.39-6.46l-.06-.15.07-.14c1.06-2.32,1.84-3.56,2.29-3.7.29-.08.76-.22,8.7,9.82.32.27,2.66,2.25,3.65,4.94,1.08,2.93-10.7,9.21-13.08,10.44-.07.06-12.38,9.21-17.44,11.83-2.01,1.04-4.4,1.38-6.58,1.4l.02.02h0Z"
                        fill="#2f2e43" />
                    <path
                        d="m583.93,246.05l-43.56.48-3.5,40.56,18.96,149.54,22.24-.25-9.85-86.38,36.94,77.68,19.61-14.06-28.98-72.58s9.36-63.61,1.28-79.34c-8.08-15.73-13.13-15.67-13.13-15.67v.02h-.01Z"
                        fill="#2f2e43" />
                    <polygon points="605.63 248.28 536.44 249.05 556.21 159.38 586.35 159.04 605.63 248.28"
                        fill="#6c63ff" />
                    <path id="uuid-97a43cd7-1586-4870-a70d-869ca8f8714f-70"
                        d="m612.38,295.74c1.16,5.43-.8,10.42-4.39,11.15-3.59.73-7.44-3.08-8.6-8.51-.5-2.16-.45-4.41.14-6.56l-14.64-85.11,17.09-3.41,7.57,86.49c1.42,1.74,2.39,3.78,2.83,5.96h0Z"
                        fill="#f3a3a6" />
                    <path
                        d="m574.66,159.17l11.69-.13c8.28,1.16,10.57,5.55,12.54,13.67,3,12.39,6.85,28.89,6.13,29.14-1.17.4-20.95,9.98-31.12,7.95l.77-50.63h-.01Z"
                        fill="#6c63ff" />
                </g>
                <path
                    d="m680.22,466.56c0,.54-.44.98-.98.98h-213.12c-.54,0-.98-.44-.98-.98s.44-.98.98-.98h213.12c.54,0,.98.44.98.98Z"
                    fill="#3f3d58" />
            </svg>
        </div>
    </div>
</body>

</html>
