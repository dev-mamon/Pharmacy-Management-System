import "./bootstrap";
(function () {
    const mobileBtn = document.getElementById("mobileSidebarButton");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    const toggleBtn = document.getElementById("toggleSidebarButton");
    const profileButton = document.getElementById("profileButton");
    const profileDropdown = document.getElementById("profileDropdown");

    function openMobileSidebar() {
        sidebar.classList.remove("-translate-x-full");
        overlay.classList.remove("hidden");
        mobileBtn.setAttribute("aria-expanded", "true");
        sidebar.setAttribute("aria-hidden", "false");
        overlay.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
    }

    function closeMobileSidebar() {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
        mobileBtn.setAttribute("aria-expanded", "false");
        sidebar.setAttribute("aria-hidden", "true");
        overlay.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
    }

    mobileBtn.addEventListener("click", (e) => {
        const expanded = mobileBtn.getAttribute("aria-expanded") === "true";
        if (expanded) closeMobileSidebar();
        else openMobileSidebar();
    });

    overlay.addEventListener("click", closeMobileSidebar);

    // collapse/expand desktop sidebar w/ aria
    toggleBtn.addEventListener("click", () => {
        const collapsed = sidebar.getAttribute("data-collapsed") === "true";
        if (collapsed) {
            sidebar.classList.remove("lg:w-16");
            sidebar.classList.add("lg:w-64");
            sidebar.setAttribute("data-collapsed", "false");
            document
                .querySelectorAll(".sidebar-text")
                .forEach((el) => el.classList.remove("hidden"));
            document.getElementById("sidebarTitle").classList.remove("hidden");
            toggleBtn.setAttribute("aria-expanded", "true");
            sidebar.setAttribute("aria-hidden", "false");
        } else {
            sidebar.classList.remove("lg:w-64");
            sidebar.classList.add("lg:w-16");
            sidebar.setAttribute("data-collapsed", "true");
            document
                .querySelectorAll(".sidebar-text")
                .forEach((el) => el.classList.add("hidden"));
            document.getElementById("sidebarTitle").classList.add("hidden");
            toggleBtn.setAttribute("aria-expanded", "false");
            sidebar.setAttribute("aria-hidden", "true");
        }
    });

    // profile dropdown toggle + aria
    profileButton.addEventListener("click", (e) => {
        e.stopPropagation();
        const isHidden = profileDropdown.classList.contains("hidden");
        profileDropdown.classList.toggle("hidden");
        profileDropdown.setAttribute(
            "aria-hidden",
            isHidden ? "false" : "true"
        );
        profileButton.setAttribute(
            "aria-expanded",
            isHidden ? "true" : "false"
        );
    });

    document.addEventListener("click", (e) => {
        if (
            !profileButton.contains(e.target) &&
            !profileDropdown.contains(e.target)
        ) {
            profileDropdown.classList.add("hidden");
            profileDropdown.setAttribute("aria-hidden", "true");
            profileButton.setAttribute("aria-expanded", "false");
        }
    });

    // close mobile sidebar when a nav link is clicked (improves UX)
    document.querySelectorAll("#sidebar nav a").forEach((a) => {
        a.addEventListener("click", () => {
            // only close if overlay visible (mobile)
            if (!overlay.classList.contains("hidden")) closeMobileSidebar();
        });
    });

    // keyboard accessibility: allow Escape to close dropdowns/overlays
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            // close profile dropdown
            profileDropdown.classList.add("hidden");
            profileDropdown.setAttribute("aria-hidden", "true");
            profileButton.setAttribute("aria-expanded", "false");
            // close mobile sidebar
            if (!overlay.classList.contains("hidden")) {
                closeMobileSidebar();
            }
        }
    });
})();
