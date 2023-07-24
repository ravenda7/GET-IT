const circluar_slider = document.querySelector('.wrapper'),
slides = document.querySelectorAll('.slides'),
images = document.querySelectorAll('.slides img');

slides.forEach((slide, i) => {
    slide.onclick = () => {
        circluar_slider.style.transform= `rotateZ(-${360 / 5 * (i + 2)}deg)`;

        images.forEach((img,i) => {
            img.style.setProperty('--img-no',2);
        })
    }
})