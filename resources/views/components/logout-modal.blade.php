<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none [&.active]:opacity-100 [&.active]:pointer-events-auto transition-opacity duration-300 group" id="modal-logout" role="dialog" aria-modal="true" aria-labelledby="modal-logout-title">
    <div class="w-full max-w-sm bg-white rounded-xl shadow-2xl p-6 scale-95 opacity-0 group-[.active]:scale-100 group-[.active]:opacity-100 transition-all duration-300">
        <h2 class="text-lg font-semibold text-gray-900" id="modal-logout-title">Log Out</h2>
        <p class="mt-2 text-gray-600">
            Are you sure you want to <span class="font-semibold text-gray-900">log out</span>?
        </p>
        
        <form method="POST" action="{{ route('logout') }}" class="flex justify-end gap-3 mt-6">
            @csrf
            <button type="button" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-md font-medium transition-colors" onclick="closeLogoutModal()">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-md font-medium transition-colors">Log Out</button>
        </form>
    </div>
</div>

<script>
    function openLogoutModal() {
        const overlay = document.getElementById('modal-logout');
        if (!overlay) return;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLogoutModal() {
        const overlay = document.getElementById('modal-logout');
        if (!overlay) return;
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close on backdrop click
    document.getElementById('modal-logout')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeLogoutModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const overlay = document.getElementById('modal-logout');
            if (overlay && overlay.classList.contains('active')) {
                closeLogoutModal();
            }
        }
    });
</script>
