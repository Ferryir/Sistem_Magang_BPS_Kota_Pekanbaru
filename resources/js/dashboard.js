document.addEventListener("DOMContentLoaded", function () {
    highlightActiveMenuItem();
    toggleSidebar();
});

//fungsi memberikan highlight ke menu yg sedang dipilih
function highlightActiveMenuItem() {
    const links = document.querySelectorAll("a.menu-item");
    const currentPath = window.location.pathname;

    links.forEach((link) => {
        const linkPath = link.getAttribute("href");

        if (currentPath.includes(linkPath) && linkPath !== "/") {
            link.classList.add(
                "bg-blue-600",
                "text-white",
                "hover:text-white",
                "font-regular",
                "dark:text-[#0f1214]",
                "dark:from-blue-400",
                "dark:to-blue-700"
            );
        } else {
            link.classList.remove("bg-blue-50", "text-blue-600");
        }
    });
}


function toggleSidebar() {
    const toggleSidebarButton = document.getElementById('toggle-sidebar');
    const sidebar = document.getElementById('application-sidebar-brand');
    const pageWrapper = document.querySelector('.page-wrapper');
    const loaderItem = document.querySelector('.img-loader');
    const menuItems = document.querySelectorAll('.menu-item');
    const icons = document.querySelectorAll('.menu-item i');

    // Function to update sidebar based on window width
    function updateSidebar() {
        const clientWidth = document.documentElement.clientWidth;
        if (clientWidth < 1280) {
            sidebar.classList.remove('aside-collapsed');
            pageWrapper.style.marginLeft = '0';
            localStorage.setItem('sidebarCollapsed', 'false');
            menuItems.forEach(item => {
                item.classList.add('justify-start');
                item.classList.remove('justify-center');
            });
            icons.forEach(icon => {
                icon.classList.add('ps-2');
            });
            loaderItem.classList.add('lg:ml-[18%]');
            loaderItem.classList.remove('lg:ml-[5%]');
        } else {
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('aside-collapsed');
                pageWrapper.style.marginLeft = '80px';
                menuItems.forEach(item => {
                    item.classList.remove('justify-start');
                    item.classList.add('justify-center');
                });
                icons.forEach(icon => {
                    icon.classList.remove('ps-2');
                });
                loaderItem.classList.add('lg:ml-[5%]');
                loaderItem.classList.remove('lg:ml-[18%]');
            } else {
                sidebar.classList.remove('aside-collapsed');
                pageWrapper.style.marginLeft = '270px';
                menuItems.forEach(item => {
                    item.classList.add('justify-start');
                    item.classList.remove('justify-center');
                });
                icons.forEach(icon => {
                    icon.classList.add('ps-2');
                });
                loaderItem.classList.add('ml-[18%]');
                loaderItem.classList.remove('ml-[5%]');
            }
        }
    }

    // Initial load of the sidebar state from localStorage
    updateSidebar();

    // Add event listener for the toggle button
    toggleSidebarButton.addEventListener('click', function () {
        sidebar.classList.toggle('aside-collapsed');

        if (sidebar.classList.contains('aside-collapsed')) {
            pageWrapper.style.marginLeft = '80px'; // Margin left after the sidebar is collapsed
            localStorage.setItem('sidebarCollapsed', 'true'); // Save the state to localStorage
            menuItems.forEach(item => {
                item.classList.remove('justify-start');
                item.classList.add('justify-center');
            });
            icons.forEach(icon => {
                icon.classList.remove('ps-2');
            });
            loaderItem.classList.add('ml-[5%]');
            loaderItem.classList.remove('ml-[18%]');
        } else {
            pageWrapper.style.marginLeft = '270px'; // Normal margin left
            localStorage.setItem('sidebarCollapsed', 'false'); // Save the state to localStorage
            menuItems.forEach(item => {
                item.classList.add('justify-start');
                item.classList.remove('justify-center');
            });
            icons.forEach(icon => {
                icon.classList.add('ps-2');
            });
            loaderItem.classList.add('ml-[18%]');
            loaderItem.classList.remove('ml-[5%]');
        }
    });

    // Add event listener for window resize
    window.addEventListener('resize', updateSidebar);
}
