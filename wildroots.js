var allButtons = document.querySelectorAll('.myBtn');
allButtons.forEach(function(btn){
  btn.addEventListener('click', myFunction);
});

function myFunction() {
  var allBtns = document.querySelectorAll(".myBtn");
  var allDots = document.querySelectorAll(".dots");
  var allMore = document.querySelectorAll(".more");
  
  var btnText = allBtns[[...allBtns].indexOf(this)];
  var dots = allDots[[...allBtns].indexOf(this)];
  var moreText = allMore[[...allBtns].indexOf(this)];

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = ""; 
    moreText.style.display = "inline";
  }
}

// Menu Mobile button
const navButton = document.querySelector('button[aria-expanded]');

function toggleNav({target}){
  const expanded = target.getAttribute('aria-expanded') === 'true' || false;
  navButton.setAttribute('aria-expanded', !expanded);
}

navButton.addEventListener('click', toggleNav);

//contact form

//navbar scroll
var navScroll = document.querySelector("#navbarPrime");

window.onscroll = function (){
  if (window.pageYOffset >= 50){
      navScroll.classList.add("colored");
      navScroll.classList.remove("transparent");
  }
  else {
      navScroll.classList.add("transparent");
      navScroll.classList.remove("colored");
  }
};
