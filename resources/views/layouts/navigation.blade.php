<header class="site-header">
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            SystemHub
        </a>

        <div class="system-navigation">
            {{-- POS menu --}}
            <details class="system-menu">
                <summary>POS System</summary>

                <div class="dropdown-menu">
                    <a
                        href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'active' : '' }}"
                    >
                        Home
                    </a>

                    @auth
                        <a
                            href="{{ route('customers.index') }}"
                            class="{{ request()->routeIs('customers.*') ? 'active' : '' }}"
                        >
                            Customers
                        </a>

                        <a
                            href="{{ route('users.index') }}"
                            class="{{ request()->routeIs('users.*') ? 'active' : '' }}"
                        >
                            Users
                        </a>
                    @endauth

                    <a
                        href="{{ route('about') }}"
                        class="{{ request()->routeIs('about') ? 'active' : '' }}"
                    >
                        About
                    </a>
                </div>
            </details>

            {{-- Task Management menu --}}
            <details class="system-menu">
                <summary>Tasks Today</summary>

                <div class="dropdown-menu">
                    <a
                        href="{{ route('tasks.today') }}"
                        class="{{ request()->routeIs('tasks.today') ? 'active' : '' }}"
                    >
                        Today
                    </a>

                    <a
                        href="{{ route('tasks.index') }}"
                        class="{{ request()->routeIs('tasks.index') ? 'active' : '' }}"
                    >
                        Task List
                    </a>

                    <a
                        href="{{ route('profile.show') }}"
                        class="{{ request()->routeIs('profile.show') ? 'active' : '' }}"
                    >
                        Profile
                    </a>

                    @auth
                        <a
                            href="{{ route('tasks.create') }}"
                            class="{{ request()->routeIs('tasks.create') ? 'active' : '' }}"
                        >
                            New Task
                        </a>
                    @endauth
                </div>
            </details>

            {{-- Authentication area --}}
            <div class="auth-navigation">
                @auth
                    <span class="auth-user">
                        {{ auth()->user()->full_name
                            ?? auth()->user()->name
                            ?? auth()->user()->email }}
                    </span>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="logout-form"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="auth-button"
                        >
                            Logout
                        </button>
                    </form>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="auth-link"
                    >
                        Login
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="auth-button"
                    >
                        Create Account
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>