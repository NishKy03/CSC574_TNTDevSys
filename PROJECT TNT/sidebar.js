function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');

    const mainContent = document.getElementById('main-content');
    mainContent.classList.toggle('sidebar-open');
}

document.getElementById('profile-picture-form').addEventListener('change', function() {
    document.getElementById('submit-profile-picture').click();
});
