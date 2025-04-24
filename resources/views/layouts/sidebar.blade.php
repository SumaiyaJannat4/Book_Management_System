<!-- Desktop Sidebar -->
<div id="sidebar"
     class="hidden md:block fixed top-16 left-0 bg-purple-900 text-white h-[calc(100vh-4rem)] w-60 p-5 pt-8 z-20 transition-all duration-300">
     <button onclick="toggleSidebar()" 
        class="bg-white text-purple-900 text-xl w-8 h-8 flex items-center justify-center rounded-full 
               border border-purple-900 absolute -right-4 top-9 cursor-pointer transition-transform rotate-icon">
  <svg id="sidebarToggleIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transform transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
  </svg>
</button>

  <div class="inline-flex items-center mb-6 mt-4">
    <div class="bg-amber-300 text-purple-900 text-xl p-1 rounded mr-2">📋</div>
    <h1 class="sidebar-text text-white font-semibold text-lg">Main Menu</h1>
  </div>

  <!-- Nav Links --> 
  <ul class="space-y-4">
    <li>
      <a href="{{ route('dashboard') }}" class="flex items-center gap-4 p-2 hover:bg-purple-700 rounded-md">
        <span>🏠</span>
        <span class="sidebar-text">Dashboard</span>
      </a>
    </li>
    <li>
      <a href="{{ route('books.index') }}" class="flex items-center gap-4 p-2 hover:bg-purple-700 rounded-md">
        <span>📖</span>
        <span class="sidebar-text">Books</span>
      </a>
    </li>
    <li>
      <a href="{{ route('publishers.index') }}" class="flex items-center gap-4 p-2 hover:bg-purple-700 rounded-md">
        <span>🖨️</span>
        <span class="sidebar-text">Publisher</span>
      </a>
    </li>
  </ul>
</div>

<!-- Mobile Sidebar Overlay -->
<div id="mobileSidebarOverlay"
     class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden hidden">
  <div class="bg-purple-900 w-60 h-full p-5 pt-8">
    <ul class="space-y-4 text-white">
      <li><a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 hover:bg-purple-700 rounded-md">🏠 Dashboard</a></li>
      <li><a href="{{ route('books.index') }}" class="flex items-center gap-3 p-2 hover:bg-purple-700 rounded-md">📖 Books</a></li>
      <li><a href="{{ route('publishers.index') }}" class="flex items-center gap-3 p-2 hover:bg-purple-700 rounded-md"><span class="bg-white text-purple-900 rounded-full p-1 text-sm">👤</span> Publisher</a></li>
    </ul>
  </div>
</div>

<!-- Mobile Menu Button -->
<button id="mobileMenuBtn" onclick="toggleMobileSidebar()" 
        class="md:hidden fixed top-4 left-4 z-40 bg-gray-100 hover:bg-gray-200 p-2 rounded shadow">
  <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
  </svg>
</button>

<!-- Sidebar Script -->
<script>
    
 function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');

      sidebar.classList.toggle('w-60');
      sidebar.classList.toggle('w-20');

      content.classList.toggle('ml-60');
      content.classList.toggle('ml-20');

      document.querySelectorAll('.sidebar-text').forEach(el => el.classList.toggle('hidden'));
      document.querySelector('.rotate-icon').classList.toggle('rotate-180');
    }
    function toggleMobileSidebar() {
    const overlay = document.getElementById('mobileSidebarOverlay');
    const menuBtn = document.getElementById('mobileMenuBtn');
    const content = document.getElementById('content');
    content.classList.toggle('ml-0');
    overlay.classList.toggle('hidden');
    
    // Hide menu button 
    if (!overlay.classList.contains('hidden')) {
      menuBtn.classList.add('hidden');
    } else {
      menuBtn.classList.remove('hidden');
    }
  }

  // Close mobile sidebar 
  document.getElementById('mobileSidebarOverlay')?.addEventListener('click', function (e) {
    if (e.target === this) {
      this.classList.add('hidden');
      document.getElementById('mobileMenuBtn').classList.remove('hidden'); 
    }
  });

</script>