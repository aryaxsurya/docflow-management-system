<!-- ================= SIDEBAR ================= -->
<aside class="w-64 glass min-h-screen p-6 flex flex-col justify-between">

    <div>
        <h2 class="text-2xl font-bold text-purple-300 mb-10">
            Admin Panel
        </h2>

        <nav class="space-y-2 text-sm">

            <p class="text-purple-400 uppercase text-xs mb-2">Overview</p>
            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Dashboard
            </a>

            <p class="text-purple-400 uppercase text-xs mt-6 mb-2">User Management</p>
            <a href="{{ route('admin.user.approvals') }}"
               class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Pending Users
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                All Users
            </a>
            <a href="{{ route('admin.users.suspended') }}"
                class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Suspended Users
            </a>

            <p class="text-purple-400 uppercase text-xs mt-6 mb-2">Document Workflow</p>
            <a href="{{ route('admin.documents.draft') }}" class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Draft Documents
            </a>
            <a href="{{ route('admin.documents.review') }}" class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Under Review
            </a>
            <a href="{{ route('admin.documents.approval') }}" class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Waiting Approval
            </a>
            <a href="{{ route('admin.documents.signing') }}" class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Signing Process
            </a>
            <a href="{{ route('admin.documents.archive') }}"
               class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Archived
            </a>

            <p class="text-purple-400 uppercase text-xs mt-6 mb-2">System</p>
            <a href="{{ route('admin.audit-log') }}" class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Audit Log
            </a>
            <a href="{{ route('admin.settings') }}" class="block px-4 py-2 rounded-lg menu-item hover:bg-white/10">
                Settings
            </a>
        </nav>
    </div>

    <div class="text-xs text-purple-300 mt-10">
        &copy; {{ date('Y') }} Arya Surya
    </div>
</aside>
