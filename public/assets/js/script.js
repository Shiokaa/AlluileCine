// ===== BURGER MENU =====
document.addEventListener("DOMContentLoaded", () => {
  const burgerBtn = document.querySelector(".burger-btn");
  const mainNav = document.querySelector(".main-nav");
  const overlay = document.querySelector(".nav-overlay");

  if (!burgerBtn || !mainNav) return;

  const toggleMenu = () => {
    burgerBtn.classList.toggle("active");
    mainNav.classList.toggle("open");
    overlay.classList.toggle("active");
  };

  burgerBtn.addEventListener("click", toggleMenu);
  overlay.addEventListener("click", toggleMenu);
});
