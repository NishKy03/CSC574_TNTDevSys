function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const menuToggle = document.getElementById('menu-toggle');

    sidebar.classList.toggle('open');
    mainContent.classList.toggle('sidebar-open');
    menuToggle.classList.toggle('active'); // Optional: Toggle class to change appearance if needed
}
