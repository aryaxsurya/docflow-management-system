<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white p-10">

    <h1 class="text-2xl mb-6">
        Edit User
    </h1>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="space-y-4 max-w-md">

            <input 
                type="text" 
                name="name"
                value="{{ $user->name }}"
                class="w-full p-3 rounded bg-gray-800"
            >

            <input 
                type="email" 
                name="email"
                value="{{ $user->email }}"
                class="w-full p-3 rounded bg-gray-800"
            >

            <select 
                name="role" 
                class="w-full p-3 rounded bg-gray-800"
            >
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>

                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                    User
                </option>
            </select>

            <div class="flex items-center gap-4">
                <button class="bg-purple-600 px-6 py-2 rounded">
                    Save
                </button>

                <a 
                    href="{{ route('admin.users.index') }}" 
                    class="text-gray-400"
                >
                    Back
                </a>
            </div>

        </div>
    </form>

</body>
</html>