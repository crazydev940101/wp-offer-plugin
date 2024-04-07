// Select all sliders on the page
const sliders = document.querySelectorAll('.slider');

// Loop through each slider
sliders.forEach((slider) => {
  // Select the slides and dots container for the current slider
  const slides = slider.querySelector('.slides');
  const dotsContainer = slider.querySelector('.dots');

  // Calculate the number of slides and dots
  const slidesLength = slider.querySelectorAll('.slide-item').length;
  const dotsLength = Math.ceil(slidesLength / 3);

  // Create and append dots for the current slider
  for (let i = 0; i < dotsLength; i++) {
    const dot = document.createElement('i');
    dot.classList.add('fa', 'fa-circle-o');
    dot.setAttribute('data-slide', i);
    dotsContainer.appendChild(dot);
  }

  // Select all dots for the current slider
  const dots = slider.querySelectorAll('.fa-circle-o');

  // Set the initial slide and interval for the current slider
  let currentSlide = 0;
  const interval = setInterval(() => {
    // Move to the next slide
    currentSlide++;
    if (currentSlide >= dotsLength) {
      currentSlide = 0;
    }

    // Update the slides and dots for the current slider
    slides.style.transform = `translateX(-${currentSlide * 30}%)`;
    dots.forEach(dot => dot.classList.replace('fa-circle', 'fa-circle-o'));
    dots[currentSlide].classList.replace('fa-circle-o', 'fa-circle');
  }, 1000);
});
