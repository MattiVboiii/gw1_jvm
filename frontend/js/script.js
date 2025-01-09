console.log("javascript works on frontend.......");

document.addEventListener("DOMContentLoaded", () => {
  const p = document.querySelector(".description p");
  const checkbox = document.querySelector("#readmore");
  const label = document.querySelector('label[for="readmore"]');

  // lijnhoogte opvragen
  const lineHeight = parseFloat(window.getComputedStyle(p).lineHeight);

  // de maximum hoogte bepalen door lijnhoogte en maximum aantal zichtbare lijnen
  const maxVisibleLines = 5;
  const maxHeight = lineHeight * maxVisibleLines;

  // checken of de p de max hoogte heeft gehaald
  if (p.scrollHeight > maxHeight) {
    // overflow verbergen
    p.style.maxHeight = `${maxHeight}px`;
    p.style.overflow = "hidden";
    p.style.transition = "max-height 0.3s ease";

    // event zetten voor change van de checkbox
    checkbox.addEventListener("change", () => {
      if (checkbox.checked) {
        p.style.maxHeight = `${p.scrollHeight}px`; // Expand
        label.textContent = "Collapse";
      } else {
        p.style.maxHeight = `${maxHeight}px`; // Collapse
        label.textContent = "Read more";
      }
    });
  } else {
    // al p minder dan de max hoogte is checkbox en label verbergen
    checkbox.style.display = "none";
    label.style.display = "none";
  }
});
