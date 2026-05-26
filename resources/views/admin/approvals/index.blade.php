<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pending User Approvals</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body{
font-family:'Inter',sans-serif;
background:#0a1124;
color:#e6eeff;
}

.glass{
background:rgba(255,255,255,0.06);
backdrop-filter:blur(12px);
border:1px solid rgba(255,255,255,0.1);
}
</style>

</head>
<body class="p-10">

<div class="max-w-6xl mx-auto">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
<h1 class="text-2xl font-bold text-purple-300">
👥 Pending User Registrations
</h1>

<a href="{{ route('admin.dashboard') }}"
class="text-blue-300 hover:text-blue-400">
⬅ Back to Dashboard
</a>
</div>

<!-- SUCCESS MESSAGE -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-500/20 border border-green-400 rounded">
{{ session('success') }}
</div>
@endif

<!-- TABLE -->
<div class="glass rounded-xl overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-white/5 text-purple-300">
<tr>
<th class="p-4 text-left">Name</th>
<th class="p-4 text-left">Email</th>
<th class="p-4 text-left">Role</th>
<th class="p-4 text-left">Registered</th>
<th class="p-4 text-left">Action</th>
</tr>
</thead>

<tbody>

@forelse($users as $user)

<tr class="border-t border-white/10">

<td class="p-4">
{{ $user->name }}
</td>

<td class="p-4">
{{ $user->email }}
</td>

<td class="p-4">
<span class="px-3 py-1 rounded bg-indigo-500/20 text-indigo-300 text-xs">
{{ $user->role }}
</span>
</td>

<td class="p-4">
{{ $user->created_at->diffForHumans() }}
</td>

<td class="p-4 flex gap-3">

<form action="{{ route('admin.user.approve',$user->id) }}" method="POST">
@csrf
<button class="px-4 py-1 bg-green-600 rounded hover:bg-green-700 text-sm">
Approve
</button>
</form>

<form action="{{ route('admin.user.reject',$user->id) }}" method="POST">
@csrf
<button class="px-4 py-1 bg-red-600 rounded hover:bg-red-700 text-sm">
Reject
</button>
</form>

</td>

</tr>

@empty

<tr>
<td colspan="5" class="p-6 text-center text-purple-300">
No pending registrations
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</body>
</html>