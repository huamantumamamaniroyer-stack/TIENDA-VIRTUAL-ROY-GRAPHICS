// Scroll to Top
window.onscroll = function() {
  const automotive_car_dealer_button = document.querySelector('.scroll-top-box');
  if (automotive_car_dealer_button) {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
      automotive_car_dealer_button.style.display = "block";
    } else {
      automotive_car_dealer_button.style.display = "none";
    }
  }
};

const scrollTopLink = document.querySelector('.scroll-top-box a');
if (scrollTopLink) {
  scrollTopLink.onclick = function(event) {
    event.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };
}

// lider
jQuery(document).ready(function ($) {
    $('.main-banner-sec .owl-carousel').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        dots: false,
        rtl: false,
        items: 1,
        autoplay: false,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            1024: {
                items: 1
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const limitTextElements = document.querySelectorAll(".product-sec .product-contents.wp-block-woocommerce-product-description p");
    limitTextElements.forEach((el) => {
        el.style.whiteSpace = "nowrap";
        el.style.overflow = "hidden";
        el.style.textOverflow = "ellipsis";
        el.style.display = "block";
        el.setAttribute("title", el.textContent.trim()); // full text on hover
    });
});

// js
document.addEventListener("DOMContentLoaded", () => {
    const limitTextElements = document.querySelectorAll(".product-sec .wc-block-components-product-summary p");
    limitTextElements.forEach((el) => {
        const maxLength = parseInt(el.getAttribute("data-max-length")) || 48; // default 30 chars if not specified
        const fullText = el.textContent.trim();
        if (fullText.length > maxLength) {
            el.setAttribute("title", fullText); // keep full text available on hover
            el.textContent = fullText.slice(0, maxLength).trim();
        }
    });
});