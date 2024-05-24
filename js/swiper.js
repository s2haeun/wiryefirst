$(function(){

    
    const swiper = new Swiper('.main_station.swiper', {
        // Optional parameters
        // direction: 'vertical',
        speed: 1000,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        effect: 'fade',
        crossFade:true,
    
        // If we need pagination
        pagination: {
        el: '.swiper-pagination',
        clickable: true,
        },
    
        // Navigation arrows
        navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
        }
    
        // And if we need scrollbar
        // scrollbar: {
        // el: '.swiper-scrollbar',
        // },
    });


})
