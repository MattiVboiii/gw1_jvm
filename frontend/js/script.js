function sleep(time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}

document.addEventListener("DOMContentLoaded", () => {
  const readMoreBody = document.querySelector(".readmore-body");
  const secondPart = readMoreBody.querySelector(".second");
  const checkbox = document.querySelector("#readmore");
  const label = document.querySelector('label[for="readmore"]');
  const transition =
    window.getComputedStyle(readMoreBody).transitionDuration.split("s")[0] *
    1000;
  const temp = readMoreBody.querySelector(".temp");

  let collapsedHeight;
  checkbox.addEventListener("change", async () => {
    if (checkbox.checked) {
      collapsedHeight = parseFloat(
        window.getComputedStyle(readMoreBody).height
      );
      readMoreBody.style.maxHeight = `${collapsedHeight}px`;
      secondPart.style.display = "inline";
      readMoreBody.style.maxHeight = `${readMoreBody.scrollHeight}px`; // Expand
      label.textContent = "Collapse";
      temp.style.display = "none";
      await sleep(transition);
      readMoreBody.style.maxHeight = "unset";
    } else {
      const expandedHeight = parseFloat(
        window.getComputedStyle(readMoreBody).height
      );
      readMoreBody.style.maxHeight = expandedHeight + "px";
      console.log("expandedHeight", expandedHeight + "px");
      await sleep(1);
      readMoreBody.style.maxHeight = `${collapsedHeight}px`; // Collapse
      label.textContent = "Read more";
      await sleep(transition);
      secondPart.style.display = "none";
      temp.style.display = "inline";
      readMoreBody.style.maxHeight = "unset";
    }
  });
});
