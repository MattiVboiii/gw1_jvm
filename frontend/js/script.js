console.log("javascript works on frontend.......");

document.addEventListener("DOMContentLoaded", () => {
  const readMoreBody = document.querySelector(".readmore-body");
  const firstPart = readMoreBody.querySelector(".first");
  const secondPart = readMoreBody.querySelector(".second");
  const checkbox = document.querySelector("#readmore");
  const label = document.querySelector('label[for="readmore"]');

  const transition =
    window.getComputedStyle(readMoreBody).transitionDuration.split("s")[0] *
    1000;
  const temp = readMoreBody.querySelector(".temp");

  // console.log("collapsed height", collapsedHeight);
  console.log("readMoreBody.scrollH", readMoreBody.scrollHeight);
  console.log("maxHeight", readMoreBody.style.maxHeight);
  console.log(
    "transition",
    window.getComputedStyle(readMoreBody).transitionDuration.split("s")[0] *
      1000
  );
  let collapsedHeight;
  checkbox.addEventListener("change", () => {
    // console.log("collapsed height", collapsedHeight);
    if (checkbox.checked) {
      collapsedHeight = parseFloat(
        window.getComputedStyle(readMoreBody).height
      );
      readMoreBody.style.maxHeight = `${collapsedHeight}px`;
      secondPart.style.display = "inline";
      readMoreBody.style.maxHeight = `${readMoreBody.scrollHeight}px`; // Expand
      label.textContent = "Collapse";
      temp.style.display = "none";
    } else {
      readMoreBody.style.maxHeight = `${collapsedHeight}px`; // Collapse
      label.textContent = "Read more";
      setTimeout(() => {
        secondPart.style.display = "none";
        temp.style.display = "inline";
        readMoreBody.style.maxHeight = "unset";
      }, transition);
    }
  });
});
