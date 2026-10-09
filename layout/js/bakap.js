
// Site scripts (vanilla JS — no jQuery dependency).

function toggleMenu() {
    var menu = document.getElementById('navLinks');
    if (menu) {
        menu.classList.toggle('show');
    }
}

// Back to top button
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.querySelector('.back-to-top');
    if (!btn) {
        return;
    }
    var onScroll = function () {
        if (window.scrollY > 100) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});

function toggleText() {
    var text = document.getElementById("text");
    var btn = document.getElementById("btn");
    if (!text || !btn) {
        return;
    }
    if (text.style.maxHeight === "none") {
        text.style.maxHeight = "510px";
        btn.innerHTML = "قراءة المزيد";
    } else {
        text.style.maxHeight = "none";
        btn.innerHTML = "أخفاء";
    }
}
