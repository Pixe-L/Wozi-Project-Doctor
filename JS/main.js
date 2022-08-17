$('.scroll-multi').slick({
 infinite: true,
 lazyLoad: 'ondemand',
 slidesToShow: 3,
 slidesToScroll: 1,
 arrows: true,
 dots: true,
 responsive: [
  {
   breakpoint: 768,
   settings: {
    arrows: false,
    centerMode: true,
    centerPadding: '40px',
    slidesToShow: 2,
   },
  },
  {
   breakpoint: 480,
   settings: {
    arrows: false,
    centerMode: true,
    centerPadding: '40px',
    slidesToShow: 1,
   },
  },
 ],
});

$('.news-container').slick({
 infinite: true,
 lazyLoad: 'ondemand',
 slidesToShow: 3,
 slidesToScroll: 1,
 dots: true,
 arrows: true,
 responsive: [
  {
   breakpoint: 768,
   settings: {
    arrows: false,
    centerMode: true,
    centerPadding: '40px',
    slidesToShow: 2,
   },
  },
  {
   breakpoint: 480,
   settings: {
    arrows: false,
    centerMode: true,
    centerPadding: '40px',
    slidesToShow: 1,
   },
  },
 ],
});

$('.carousel-person').slick({
 infinite: true,
 lazyLoad: 'ondemand',
 slidesToShow: 3,
 slidesToScroll: 1,
 dots: true,
 arrows: true,
 responsive: [
  {
   breakpoint: 768,
   settings: {
    arrows: false,
    centerMode: true,
    centerPadding: '40px',
    slidesToShow: 2,
   },
  },
  {
   breakpoint: 480,
   settings: {
    arrows: false,
    centerMode: true,
    centerPadding: '40px',
    slidesToShow: 1,
   },
  },
 ],
});

$('.product-carousel').slick({
 dots: true,
 infinite: true,
 lazyLoad: 'ondemand',
 slidesToShow: 1,
 slidesToScroll: 1,
 adaptiveHeight: true,
 arrows: true,
});
