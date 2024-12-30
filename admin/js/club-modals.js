const modal = document.querySelector('[id="modal-club-description"]');

modal?.addEventListener("show.bs.modal", (event) => {
  const button = event.relatedTarget;
  const paragraph = button?.nextElementSibling;
  const clubName = button?.getAttribute("data-club-name");
  const clubDesc = paragraph?.textContent;
  const title = modal.querySelector("#club-description-label");
  const desc = modal.querySelector(".modal-body > p");

  title.textContent = `Description: ${clubName}`;
  desc.textContent = clubDesc;
});
