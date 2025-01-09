const sliders = document.querySelectorAll(".slider");

sliders.forEach((sliderRef) => {
  const ulRef = sliderRef.querySelector("ul");
  let pos = 0;
  sliderRef.insertAdjacentHTML(
    "afterbegin",
    `
      <span class="prev"></span>
      <span class="next"></span>
  `
  );

  sliderRef.querySelector(".prev").style.display = "none";

  sliderRef.querySelector(".next").onclick = function () {
    sliderRef.querySelector(".prev").style.display = "block";
    pos++;
    const newValue = -100 * pos;
    ulRef.style.transform = `translateX(${newValue}%)`;
    if (pos === ulRef.children.length - 1) {
      sliderRef.querySelector(".next").style.display = "none";
    }
  };

  sliderRef.querySelector(".prev").onclick = function () {
    sliderRef.querySelector(".next").style.display = "block";
    pos--;
    const newValue = -100 * pos;
    ulRef.style.transform = `translateX(${newValue}%)`;
    if (pos === 0) {
      sliderRef.querySelector(".prev").style.display = "none";
    }
  };
});
