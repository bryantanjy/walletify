<nav x-data="{ open: false }" class="w-full z-50 bg-white border-b border-gray-100 fixed">
    <!-- Primary Navigation Menu -->
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <!-- Logo -->
                {{-- <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start"> --}}
                    <div class="flex flex-shrink-0 items-center">
                        <img class="h-9 w-auto" src="{{ asset('images/walletify-logo.png') }}" alt="Walletify">
                    </div>
                {{-- </div> --}}

                <!-- Navigation Links -->
                <div class="hidden text-center space-x-8 sm:-my-px sm:ml-8 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                        style="font-size: 16px; font-weight: bold;">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                @php
                    $userSessionType = session('user_session_type', 'personal');
                @endphp
                {{-- Account navbar --}}
                @if ($userSessionType === 'personal')
                    <div class="hidden text-center space-x-8 sm:-my-px sm:ml-8 sm:flex">
                        <x-nav-link href="{{ route('account.index') }}" :active="request()->routeIs('account.*')"
                            style="font-size: 16px; font-weight: bold;">
                            {{ __('Account') }}
                        </x-nav-link>
                    </div>
                @endif

                {{-- Record navbar --}}
                <div class="hidden text-center space-x-8 sm:-my-px sm:ml-8 sm:flex">
                    <x-nav-link href="{{ route('record.index') }}" :active="request()->routeIs('record.*')"
                        style="font-size: 16px; font-weight: bold;">
                        {{ __('Record') }}
                    </x-nav-link>
                </div>

                {{-- Budget navbar --}}
                <div class="hidden text-center space-x-8 sm:-my-px sm:ml-8 sm:flex">
                    <x-nav-link href="{{ route('budget.index') }}" :active="request()->routeIs('budget.*')"
                        style="font-size: 16px; font-weight: bold;">
                        {{ __('Budget') }}
                    </x-nav-link>
                </div>

                {{-- Expense Sharing navbar --}}
                <div class="hidden text-center space-x-8 sm:-my-px sm:ml-8 sm:flex">
                    @if ($userSessionType === 'personal')
                        <x-nav-link href="{{ route('expense-sharing.index') }}" :active="request()->routeIs('expense-sharing.*')"
                            style="font-size: 16px; font-weight: bold;">
                            {{ __('Expense Sharing') }}
                        </x-nav-link>
                    @else
                        <x-nav-link href="{{ route('groups.index') }}" :active="request()->routeIs('expense-sharing.groups.*')"
                            style="font-size: 16px; font-weight: bold;">
                            {{ __('Expense Sharing') }}
                        </x-nav-link>
                    @endif
                </div>

                {{-- Statistics navbar --}}
                <div class="hidden text-center space-x-8 sm:-my-px sm:ml-8 sm:flex">
                    <x-nav-link href="{{ route('statistic.index') }}" :active="request()->routeIs('statistic.*')"
                        style="font-size: 16px; font-weight: bold;">
                        {{ __('Statistic') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif --}}

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if ($userSessionType === 'personal')
                <x-responsive-nav-link href="{{ route('account.index') }}" :active="request()->routeIs('account.*')">
                    {{ __('Account') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link href="{{ route('record.index') }}" :active="request()->routeIs('record.*')">
                {{ __('Record') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('budget.index') }}" :active="request()->routeIs('budget.*')">
                {{ __('Budget') }}
            </x-responsive-nav-link>
            @if ($userSessionType === 'personal')
                <x-responsive-nav-link href="{{ route('expense-sharing.index') }}" :active="request()->routeIs('expense-sharing.*')">
                    {{ __('Expense Sharing') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link href="{{ route('groups.index') }}" :active="request()->routeIs('expense-sharing.groups.*')">
                    {{ __('Expense Sharing') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link href="{{ route('statistic.index') }}" :active="request()->routeIs('statistic.*')">
                {{ __('Statistic') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif --}}
            </div>
        </div>
    </div>
</nav>
