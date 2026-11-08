<header class="site-header">
    <nav class="navbar">
        <a href="{{ route('tasks.today') }}" class="logo">
            SystemHub
        </a>

        <div class="system-navigation">
            <details class="system-menu">
                <summary>POS System</summary>

                <div class="dropdown-menu">
                    <a href="{{ route('pos.home') }}">POS Home</a>
                    <a href="{{ route('customers.index') }}">Customers</a>
                    <a href="{{ route('users.index') }}">Users</a>
                    <a href="{{ route('pos.about') }}">About POS</a>
                </div>
            </details>

            <details class="system-menu">
                <summary>Tasks Today</summary>

                <div class="dropdown-menu">
                    <a href="{{ route('tasks.today') }}">Today's Tasks</a>
                    <a href="{{ route('tasks.index') }}">All Tasks</a>
                    <a href="{{ route('tasks.profile') }}">Profile</a>
                    <a href="{{ route('tasks.about') }}">About Tasks</a>
                </div>
            </details>
        </div>
    </nav>
</header>